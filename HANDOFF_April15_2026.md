# HANDOFF — April 15, 2026
## Get to Know Claude — Post-Launch Session

---

## STATUS SUMMARY

The book **Get to Know Claude** is now LIVE and SELLING.

- **Kindle / Amazon:** Live at https://www.amazon.com/dp/B0GX2RFB23
- **Draft2Digital ebook:** In process — being distributed to all D2D channels
- **D2D print:** Manuscript PDF assembled this session — ready to upload
- **Lulu print:** Not yet submitted

---

## ALL FOUR ISBNs (from ePub frontmatter.xhtml)

- 978-0-9686037-6-5 — Paperback
- 978-0-9686037-8-9 — Hardcover
- 978-0-9686037-2-7 — eBook
- 978-0-9686037-4-1 — Spanish edition (in production, ~2-3 weeks)

**ACTION REQUIRED:** Copyright page in GTKC_Interior_Final.pdf currently reads
"ISBN pending" — all four ISBNs must be added before print submission.

---

## COMPLETED THIS SESSION

### 1. Website (GetToKnowClaude.com)

- Site confirmed live and fully functional
- WordPress login recovered via MySQL password reset:
  sudo mysql -e "UPDATE gtkc_db.wp_users SET user_pass=MD5('NewPass2026') WHERE user_login='GandhiP';"
  NOTE: Change this password — it is temporary and weak
- WordPress users: GandhiP (admin), BarriosL / Laura Barrios (admin)
- All Buy on Kindle links updated to https://www.amazon.com/dp/B0GX2RFB23
  Nav bar: updated via Customizer > Menus
  Hero/footer/about: updated via SSH sed command on 4 theme PHP files
- Downloads page confirmed showing Chapter 6 with correct GitHub link
- GitHub repo public: https://github.com/SuperiorHomeAutomation/GetToKNowClaude-Downloads

### 2. Manuscript PDF Assembled (GTKC_Manuscript.pdf)

179-page PDF for D2D print submission:
- Page 1: Front cover
- Pages 2-177: Interior (176 pages)
- Page 178: Inside back cover (Coming Soon)
- Page 179: Back cover
- Size: 6x9, 5.2MB

NOTE: ISBN pending on copyright page — must be fixed before final submission.

---

## PENDING TASKS

### High Priority

1. Update copyright page with all four ISBNs (edit source, regenerate interior PDF, rebuild manuscript)
2. Change wp-admin password from temporary NewPass2026 to something strong
3. Configure WP Mail SMTP — password reset emails not arriving (caused today's lockout)
4. Submit to D2D print — upload manuscript once ISBN is fixed; D2D handles trim/cover

### Medium Priority

5. Lulu print submission — after D2D print sorted
6. Downloads page — add chapters to GitHub as created; link by chapter not root
7. Rank Math SEO — still not installed on WordPress

### Spanish Edition (~2-3 weeks)

8. Update website with Spanish edition announcement and buy link

---

## KEY FILES THIS SESSION

- GTKC_Manuscript.pdf — 179-page D2D print manuscript
- GTKC_Wraparound_Cover_7x9.pdf — 7x9 wraparound with spine placeholder
- GTKC_Cover_7x9.docx — Word wraparound template

---

## SERVER REFERENCE

- AWS Lightsail, Ubuntu
- WordPress: /var/www/gettoknowclaude/
- Theme: /var/www/gettoknowclaude/wp-content/themes/gtkc/
- Database: gtkc_db
- MySQL access: sudo mysql (no password needed)

---

## EPUB FILE

- GTKC_Apple__2_.epub — full 12-chapter book
- ISBNs found in: EPUB/frontmatter.xhtml

---

Next session: fix copyright page ISBNs, configure WP Mail SMTP, submit D2D print.
