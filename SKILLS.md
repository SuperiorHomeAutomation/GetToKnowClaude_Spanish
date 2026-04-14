# SKILLS.md — Get to Know Claude Book Project
# Skills, capabilities, and workflows for this repository

---

## Document Creation

All chapters are produced as .docx files using the docx npm library.
Script files are named chapter1.js, chapter2.js, etc. in /home/claude/

### To regenerate any chapter:
```bash
cd /home/claude
node chapter1.js   # regenerates GTKC_Chapter1_HelloClaude.docx
```

---

## Chapter Processing Workflow

When Parmod uploads a chapter for review, follow these steps in order.
**This is the standard pass for every chapter going forward.**

### Step 0 — Copy scripts if not already present
```bash
cp /mnt/skills/public/docx/scripts /home/claude/scripts -r
```

### Step 1 — Unpack and extract content
```bash
python3 scripts/office/unpack.py uploaded.docx unpacked/
pandoc --track-changes=all uploaded.docx -o content.md
```

### Step 2 — Voice check
Scan for words Parmod does not use. See words-to-avoid table in CLAUDE.md.
```bash
grep -in "stuckness\|unsticking\|bloodless\|utilize\|leverage\|robust\|seamless\
\|paradigm\|holistic\|impactful\|transformative\|actionable\|endeavor\|commence\
\|plethora\|myriad\|synerg" content.md
```
Report every hit. Suggest plain replacements. Parmod approves — then fix.

### Step 3 — Amazon safety scan
```bash
grep -in "claude wrote\|claude generated\|AI-generated\|writing collaborator\
\|ghost-written\|collaborated on\|claude improved\|drafted sections\
\|thinking partner\|Role of AI\|by Claude\|claude drafted\|written with claude\
\|exists because claude\|claude made it possible\|claude helped build\|claude helped write" content.md
```
Also scan for softer phrases:
```bash
grep -in "writing partner\|claude built\|claude enabled\|foreword by claude" content.md
```
Key judgment: does it sound like Claude did the creative work, or like the author used a tool?
IMPORTANT: Foreword must be removed entirely from Amazon versions — never just reworded.

### Step 4 — Teaser check
Confirm the "Ready for Chapter N?" box at the end points to the correct next chapter.
With 12 chapters now, check the number carefully each time.

### Step 5 — Formatting pass (styles.xml)
Apply the master style standard to the styles.xml of the unpacked document.

**Heading 1** — add keepNext:
```xml
<w:style w:type="paragraph" w:styleId="Heading1">
  <w:name w:val="heading 1"/>
  <w:uiPriority w:val="9"/>
  <w:qFormat/>
  <w:pPr>
    <w:keepNext/>
    <w:spacing w:before="360" w:after="200"/>
    <w:outlineLvl w:val="0"/>
  </w:pPr>
  <w:rPr>
    <w:b/><w:bCs/>
    <w:color w:val="1F3864"/>
    <w:sz w:val="36"/><w:szCs w:val="36"/>
  </w:rPr>
</w:style>
```

**Heading 2** — add keepNext:
```xml
<w:style w:type="paragraph" w:styleId="Heading2">
  <w:name w:val="heading 2"/>
  <w:uiPriority w:val="9"/>
  <w:unhideWhenUsed/>
  <w:qFormat/>
  <w:pPr>
    <w:keepNext/>
    <w:spacing w:before="280" w:after="160"/>
    <w:outlineLvl w:val="1"/>
  </w:pPr>
  <w:rPr>
    <w:b/><w:bCs/>
    <w:color w:val="2E75B6"/>
    <w:sz w:val="26"/><w:szCs w:val="26"/>
  </w:rPr>
</w:style>
```

**Heading 3** — full definition with keepNext:
```xml
<w:style w:type="paragraph" w:styleId="Heading3">
  <w:name w:val="heading 3"/>
  <w:uiPriority w:val="9"/>
  <w:unhideWhenUsed/>
  <w:qFormat/>
  <w:pPr>
    <w:keepNext/>
    <w:spacing w:before="240" w:after="120"/>
    <w:outlineLvl w:val="2"/>
  </w:pPr>
  <w:rPr>
    <w:b/>
    <w:color w:val="1F4D78"/>
  </w:rPr>
</w:style>
```

Use str_replace to update styles.xml. Always verify the existing definition first
with grep or sed before replacing.

### Step 6 — Convert bold Normal sub-headings to Heading 3
Look for paragraphs that are bold Normal text acting as sub-headings.
These should use pStyle Heading3 instead. Examples: "When to update your CLAUDE.md",
"The photo renaming problem", etc.

In document.xml, replace patterns like:
```xml
<w:pPr><w:spacing .../></w:pPr>
<w:r><w:rPr><w:b/></w:rPr><w:t>Sub-heading text</w:t></w:r>
```
With:
```xml
<w:pPr><w:pStyle w:val="Heading3"/><w:spacing .../></w:pPr>
<w:r><w:t>Sub-heading text</w:t></w:r>
```

### Step 7 — Apply fixes
Use str_replace directly on unpacked XML for all fixes identified above.
Report every change and why before delivering.

### Step 8 — Repack and validate
```bash
python3 scripts/office/pack.py unpacked/ output_fixed.docx --original original.docx
```
All validations must PASS. Fix before delivering if any fail.

### Step 9 — Create Amazon-safe version
Copy the fixed original unpacked folder, apply Amazon substitutions, repack as _Amazon.docx.
See Amazon-Safe Conversion Workflow below.

### Step 10 — Deliver both files
```bash
cp output_fixed.docx /mnt/user-data/outputs/
cp output_Amazon.docx /mnt/user-data/outputs/
```

---

## Batched Tool Usage — Efficiency Standard

To minimize tool calls per chapter, always batch operations as follows.
Target: 4–5 tool calls per chapter total.

### Pass 1 — Unpack + All Scans (1 tool call)
```bash
python3 scripts/office/unpack.py uploaded.docx unpacked/
pandoc --track-changes=all uploaded.docx -o content.md

# Voice check
grep -in "stuckness\|unsticking\|bloodless\|utilize\|leverage\|robust\|seamless\
\|paradigm\|holistic\|impactful\|transformative\|actionable\|endeavor\|commence\
\|plethora\|myriad\|synerg" content.md

# Amazon scan
grep -in "claude wrote\|claude generated\|AI-generated\|writing collaborator\
\|ghost-written\|collaborated on\|claude improved\|drafted sections\
\|thinking partner\|Role of AI\|by Claude\|claude drafted\|written with claude\
\|exists because claude\|claude made it possible\|claude helped build\|claude helped write\
\|writing partner\|claude built\|claude enabled\|foreword by claude" content.md

# Heading styles + bold Normal sub-heading scan (single python3 call)
python3 -c "
import re
with open('unpacked/word/styles.xml') as f: s = f.read()
for sid in ['Heading1','Heading2','Heading3']:
    m = re.search(r'styleId=\"' + sid + r'\".*?</w:style>', s, re.DOTALL)
    print(f'=={sid}=='); print(m.group()[:500] if m else 'NOT FOUND')
with open('unpacked/word/document.xml') as f: content = f.read()
paras = re.split(r'(?=<w:p[ >])', content)
for i, p in enumerate(paras):
    if not p.strip().startswith('<w:p'): continue
    txt = ' '.join(re.findall(r'<w:t[^>]*>(.*?)</w:t>', p)).strip()
    has_bold = '<w:b/>' in p
    has_pstyle = '<w:pStyle' in p
    if not has_pstyle and has_bold and txt and txt not in ['You:','Claude:']:
        spacing = re.findall(r'<w:spacing[^/]*/>', p)
        print(f'Para {i}: [{txt[:80]}] {spacing}')
"
```

### Pass 2 — Report to Parmod
Report all findings. For voice/Amazon hits, propose replacements and wait for
approval before proceeding. Do not apply any changes until confirmed.

### Pass 3 — All XML fixes in one Python script (1 tool call)
Fix styles.xml (H1/H2/H3 keepNext + spacing + size) and document.xml
(bold Normal → Heading3 conversions + voice/Amazon replacements) in a
single `python3 -c "..."` call. Never use separate tool calls for individual
str_replace edits — batch everything into one script.

### Pass 4 — Pack + validate + deliver (1 tool call)
```bash
python3 scripts/office/pack.py unpacked/ output_fixed.docx --original original.docx
# All validations must PASS before copying to outputs
cp output_fixed.docx /mnt/user-data/outputs/
```

### Key rules
- NEVER deliver two identical files — only create an _Amazon version if there
  are actual Amazon changes to make
- NEVER use separate tool calls for individual XML edits — batch all into one
  Python script
- ALWAYS check paraId, rsidR, rsidP, and lastRenderedPageBreak when a
  paragraph match fails — these attributes vary and must be matched exactly
- Bold Normal paragraphs that are emphasis sentences (no w:before spacing,
  or are closing callouts) are NOT converted to Heading3 — only standalone
  section sub-headings with w:before spacing qualify

---

## Amazon-Safe Conversion Workflow

### Step 1 — Copy unpacked folder from fixed original
```bash
cp -r unpacked/ unpacked_amazon/
```

### Step 2 — Scan for flaggable phrases
```bash
grep -n "claude wrote\|claude generated\|AI-generated\|writing collaborator\
\|ghost-written\|collaborated on\|claude improved\|drafted sections\
\|thinking partner\|Role of AI\|by Claude\|foreword" unpacked_amazon/word/document.xml
```

### Step 3 — Apply substitutions
Use str_replace for each flaggable phrase. See CLAUDE.md substitution table.

### Step 4 — Remove foreword if present
If the document contains a foreword by Claude, remove the entire foreword section.
Use Python to find paragraph boundaries and cut:
```python
with open('unpacked_amazon/word/document.xml', 'r', encoding='utf-8') as f:
    content = f.read()
start_idx = content.find('<w:p ... paraId="FOREWORD_START_ID"')
end_idx = content.find('<w:p ... paraId="NEXT_SECTION_START_ID"')
new_content = content[:start_idx] + content[end_idx:]
with open('unpacked_amazon/word/document.xml', 'w', encoding='utf-8') as f:
    f.write(new_content)
```

### Step 5 — Validate and repack
```bash
python3 scripts/office/pack.py unpacked_amazon/ output_Amazon.docx --original original.docx
```
All validations must PASS.

### Step 6 — Naming convention
```
Original:      GTKC_ChapterN_Title.docx
Amazon-safe:   GTKC_ChapterN_Title_Amazon.docx
```

---

## Style Reference

### Document formatting standards:
- Page size: US Letter (12240 x 15840 DXA)
- Margins: 1 inch all sides (1440 DXA)
- Body font: Arial 12pt (24 half-points)
- Heading 1: Arial 18pt bold, color 1F3864, keepNext, spacing 360/200
- Heading 2: Arial 13pt bold, color 2E75B6, keepNext, spacing 280/160
- Heading 3: Arial 12pt bold, color 1F4D78, keepNext, spacing 240/120
- Info box: border 2E75B6, fill EBF3FB
- Warning box: border C0392B, fill FDEDEC
- Dialogue box: border AAAAAA, fill F9F9F9
- Code box: border 888888, fill F5F5F5

### Dialogue box format:
- Label "You:" bold, user text italic
- Label "Claude:" bold, Claude response normal

---

## KDP Submission Settings

- Title: Get to Know Claude
- Subtitle: Your AI Thinking Partner
- Author: Parmod K. Gandhi
- Price: $2.99 USD / $3.99 CAD — 70% royalty
- Text to Speech: ENABLED (critical)
- Categories: Computers & Technology > Artificial Intelligence
             Self-Help > Personal Productivity
- Keywords: see GTKC_KDP_Submission.md

---

## Repository File Naming Conventions

```
GTKC_[ChapterN]_[Title].docx          — original chapter
GTKC_[ChapterN]_[Title]_Amazon.docx   — Amazon-safe version
FrontMatter_Final.docx                — original front matter
FrontMatter_Amazon.docx               — Amazon-safe front matter (foreword removed)
```

---

## Important Constraints

- NEVER modify original files — always create new _Amazon versions
- NEVER change the dedication, Carbonell quote, or Chapter 12 closing line
- NEVER include the foreword in Amazon versions
- ALWAYS validate docx after repacking — all validations must PASS
- ALWAYS preserve the author's voice — warm, direct, no jargon
- ALWAYS apply keepNext to all heading styles
- ALWAYS report proposed changes to Parmod before applying them
