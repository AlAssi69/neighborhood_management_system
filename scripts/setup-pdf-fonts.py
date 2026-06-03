#!/usr/bin/env python3
"""
Build mPDF-ready Cairo TTFs from @fontsource/cairo (woff2) and convert Qomra.

Cairo must merge arabic + latin subsets so digits and Arabic both render (arabic-only
subsets lack 0-9 and cause "tofu" boxes in PDF tables).

Run from repo root after: npm install @fontsource/cairo --no-save
    pip install fonttools brotli
    python scripts/setup-pdf-fonts.py
"""

from __future__ import annotations

import subprocess
import sys
import tempfile
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
CAIRO_OUT = ROOT / "resources" / "fonts" / "pdf" / "cairo"
FONTSOURCE = ROOT / "node_modules" / "@fontsource" / "cairo" / "files"

CAIRO_PAIRS = [
    ("cairo-arabic-400-normal.woff2", "cairo-latin-400-normal.woff2", "Cairo-Regular.ttf"),
    ("cairo-arabic-700-normal.woff2", "cairo-latin-700-normal.woff2", "Cairo-Bold.ttf"),
]


def woff2_to_ttf(src: Path, dest: Path) -> None:
    from fontTools.ttLib import TTFont

    font = TTFont(src)
    font.flavor = None
    font.save(dest)


def build_cairo() -> None:
    from fontTools.merge import Merger
    from fontTools.ttLib import TTFont

    CAIRO_OUT.mkdir(parents=True, exist_ok=True)

    with tempfile.TemporaryDirectory() as tmp:
        tmp_path = Path(tmp)
        for arabic_name, latin_name, dest_name in CAIRO_PAIRS:
            arabic_src = FONTSOURCE / arabic_name
            latin_src = FONTSOURCE / latin_name
            for src in (arabic_src, latin_src):
                if not src.exists():
                    print(f"Missing {src}. Run: npm install @fontsource/cairo --no-save", file=sys.stderr)
                    sys.exit(1)

            arabic_ttf = tmp_path / f"{dest_name}-ar.ttf"
            latin_ttf = tmp_path / f"{dest_name}-la.ttf"
            woff2_to_ttf(arabic_src, arabic_ttf)
            woff2_to_ttf(latin_src, latin_ttf)

            out = CAIRO_OUT / dest_name
            Merger().merge([str(arabic_ttf), str(latin_ttf)]).save(out)

            cmap = TTFont(out).getBestCmap()
            if 0x0030 not in cmap or 0x0627 not in cmap:
                print(f"Warning: {dest_name} missing digits or Arabic after merge", file=sys.stderr)
                sys.exit(1)

            print(f"Wrote {out.relative_to(ROOT)}")


def main() -> int:
    build_cairo()
    result = subprocess.run(
        [sys.executable, str(ROOT / "scripts" / "convert-qomra-for-mpdf.py")],
        check=False,
    )
    return result.returncode


if __name__ == "__main__":
    raise SystemExit(main())
