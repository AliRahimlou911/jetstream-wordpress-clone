# Jetstream Vacations: WordPress guide

## 1. Install or move to your hosting

1. Install WordPress on your hosting. Most hosts have a one-click installer.
2. In the WordPress admin go to **Appearance > Themes > Add New > Upload Theme**, choose `jetstream-theme.zip` and click **Install Now**, then **Activate**.
3. That's it. When the theme is activated for the first time it creates everything automatically:
   - the pages Home, About Us, Contact Us and Booking, with Home set as the front page
   - the header and footer menus
   - the 4 destinations, 6 FAQs, 4 cabin types and 12 cruise partners
   - all images, added to the Media Library
   - tidy page links (yoursite.com/about/)
4. Go to **Settings > General** and check that the Administration Email Address is right. Form enquiries go there unless you set a different address (see section 3).

**Email delivery:** many hosts block or junk-mail WordPress emails. Install the free plugin **WP Mail SMTP** and connect it to your email provider. Even if an email never arrives, every enquiry is still saved under **Enquiries** in the admin.

## 2. Where to edit what

| What you want to change | Where to go |
|---|---|
| Phone, email, address, opening hours | Appearance > Customize > Jetstream site content > Contact details |
| Logo, header button, footer text, Google description | ... > Logo & header |
| Home page text, buttons and images (hero, sections, call to action) | ... > Home: hero / destinations / FAQ / three steps / call to action |
| About page images, "How we look after you", partner section text | ... > About page |
| Contact form topics and the "thank you" message | ... > Contact page |
| Booking form dropdown options, cabin section text, amenities list | ... > Booking page |
| Destination cards (name, code, season, length, photo) | **Destinations** in the left menu |
| FAQ questions and answers | **FAQs** in the left menu |
| Cabin types and which amenities each one has | **Cabin types** in the left menu |
| Cruise line partner names | **Cruise partners** in the left menu |
| Top title, intro text and background photo of the About, Contact and Booking pages | **Pages** > edit the page > "Page hero" box (the photo is the "Featured image") |
| "Our story" text on the About page | **Pages** > About Us > the main text area |
| Menu links | Appearance > Menus |
| Messages people send through the site | **Enquiries** in the left menu |

The Customizer shows a live preview. Click **Publish** to save.

## 3. Small tips

- **Italic blue words in headings:** wrap the words in asterisks. For example, `Set sail where the *warm wind* takes you.` shows "warm wind" in italic blue.
- **Changing the order** of destinations, FAQs, cabins or partners: open an item and change the **Order** number in the "Page Attributes" box. Lower numbers come first.
- **Adding a destination:** Destinations > Add destination. Give it a title, fill in the details and set a Featured image (portrait photos look best, about 900 × 1100 px). It appears on the home page and in the booking form automatically.
- **Form email address:** Customize > Jetstream site content > Contact details > "Send form enquiries to".
- **Images:** keep photos under about 300 KB so the site stays fast. Free tools like squoosh.app shrink them without losing quality.
- **New pages:** Pages > Add New. A new page gets the same header, hero and footer automatically, and you write the body in the normal editor.

## 4. SEO

The theme already sets the page title, meta description, social sharing image, canonical links and travel agency schema. For extra control (sitemaps, per-page keywords) you can install Yoast SEO or Rank Math. The theme notices it and stops adding its own tags, so nothing is duplicated.
