# Portfolio Repository

This repository contains two creative portfolio websites:

1. `index.html` - Developer portfolio for Shreyansh Pandya
2. `father_portfolio.html` - Astrologer/Pandit portfolio for Hitesh Pandya (Shastri)

## Files

- `index.html` (main portfolio)
- `styles.css` (styles for Shreyansh portfolio)
- `resume.md` (text resume for Shreyansh)
- `father_portfolio.html` (astrologer portfolio)
- `father_styles.css` (styles for Hitesh portfolio)
- `IMG_20200128_140424.jpg` (father photo; place this in root for portrait display)

## Usage

1. Open local in browser:
   - Double click `index.html` or `father_portfolio.html`
   - Or run local server from terminal:
     - `cd c:\Users\BAPS\Desktop\portfolio`
     - `python -m http.server 8000`
     - visit `http://localhost:8000/index.html` and `http://localhost:8000/father_portfolio.html`

2. To host on GitHub Pages:
   - Create a repository and push all files.
   - In repo settings, Pages source: `main` / root.
   - use url: `https://<username>.github.io/<repo>/index.html`
   - and `father_portfolio.html`.

3. To host on Netlify:
   - Go to `https://app.netlify.com/drop`
   - Zip the folder and drop it.
   - Take the generated URL.

## Customization instructions

- Change the text directly in HTML files.
- Replace `IMG_20200128_140424.jpg` with your own full-body photo.
- Add or edit content in the services list to suit requirements.
- Translate text in three languages via language switcher in `father_portfolio.html`.

## Troubleshooting

- If photo is not visible:
  - confirm file is in root folder and name matches exactly.
  - if name differs, update `src` in `father_portfolio.html`.

- If style not applied:
  - make sure both HTML files reference their CSS files exactly.

## Optional next steps

- Add custom domain with GitHub Pages or Netlify.
- Add `cv.pdf` or `resume.pdf` generation.
- Add hosted links to social profiles.
