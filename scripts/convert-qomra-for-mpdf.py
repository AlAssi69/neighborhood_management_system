#!/usr/bin/env python3
"""
Convert itf Qomra Arabic OTF/CFF fonts to TrueType-outline TTFs for mPDF.

mPDF cannot embed fonts with PostScript/CFF outlines (sfntVersion OTTO).
Uses fonttools' otf2ttf recipe (cubic → quadratic glyf).

Usage (from repo root):
    pip install fonttools brotli
    python scripts/convert-qomra-for-mpdf.py

Input:  public/fonts/qomra/Qomra-Regular.ttf, Qomra-Black.ttf
Output: resources/fonts/pdf/qomra/Qomra-Regular-mpdf.ttf, Qomra-Black-mpdf.ttf
"""

from __future__ import annotations

import sys
from pathlib import Path

from fontTools.pens.cu2quPen import Cu2QuPen
from fontTools.pens.ttGlyphPen import TTGlyphPen
from fontTools.ttLib import TTFont, newTable

ROOT = Path(__file__).resolve().parents[1]
SOURCES = {
    "Qomra-Regular.ttf": "Qomra-Regular-mpdf.ttf",
    "Qomra-Black.ttf": "Qomra-Black-mpdf.ttf",
}
SRC_DIR = ROOT / "public" / "fonts" / "qomra"
OUT_DIR = ROOT / "resources" / "fonts" / "pdf" / "qomra"

MAX_ERR = 1.0
REVERSE_DIRECTION = True


def glyphs_to_quadratic(glyphs, max_err: float = MAX_ERR, reverse_direction: bool = REVERSE_DIRECTION) -> dict:
    quad_glyphs = {}
    for gname in glyphs.keys():
        glyph = glyphs[gname]
        tt_pen = TTGlyphPen(glyphs)
        cu2qu = Cu2QuPen(tt_pen, max_err, reverse_direction=reverse_direction)
        glyph.draw(cu2qu)
        quad_glyphs[gname] = tt_pen.glyph()
    return quad_glyphs


def update_hmtx(tt_font: TTFont, glyf) -> None:
    hmtx = tt_font["hmtx"]
    for glyph_name, glyph in glyf.glyphs.items():
        if hasattr(glyph, "xMin"):
            hmtx[glyph_name] = (hmtx[glyph_name][0], glyph.xMin)


def otf_to_ttf(tt_font: TTFont) -> None:
    if tt_font.sfntVersion != "OTTO" or "CFF " not in tt_font:
        return

    glyph_order = tt_font.getGlyphOrder()

    tt_font["loca"] = newTable("loca")
    tt_font["glyf"] = glyf = newTable("glyf")
    glyf.glyphOrder = glyph_order
    glyf.glyphs = glyphs_to_quadratic(tt_font.getGlyphSet())
    del tt_font["CFF "]
    glyf.compile(tt_font)
    update_hmtx(tt_font, glyf)

    tt_font["maxp"] = maxp = newTable("maxp")
    maxp.tableVersion = 0x00010000
    maxp.maxZones = 1
    maxp.maxTwilightPoints = 0
    maxp.maxStorage = 0
    maxp.maxFunctionDefs = 0
    maxp.maxInstructionDefs = 0
    maxp.maxStackElements = 0
    maxp.maxSizeOfInstructions = 0
    maxp.maxComponentElements = max(
        len(g.components if hasattr(g, "components") else [])
        for g in glyf.glyphs.values()
    )
    maxp.compile(tt_font)

    post = tt_font["post"]
    post.formatType = 2.0
    post.extraNames = []
    post.mapping = {}
    post.glyphOrder = glyph_order
    try:
        post.compile(tt_font)
    except OverflowError:
        post.formatType = 3

    tt_font.sfntVersion = "\000\001\000\000"


def convert(src: Path, dest: Path) -> None:
    font = TTFont(src)
    otf_to_ttf(font)
    dest.parent.mkdir(parents=True, exist_ok=True)
    font.save(dest)
    print(f"Wrote {dest.relative_to(ROOT)}")


def main() -> int:
    missing = [name for name in SOURCES if not (SRC_DIR / name).exists()]
    if missing:
        print(f"Missing source fonts in {SRC_DIR}:", ", ".join(missing), file=sys.stderr)
        return 1

    for src_name, out_name in SOURCES.items():
        convert(SRC_DIR / src_name, OUT_DIR / out_name)

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
