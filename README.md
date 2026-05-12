# 🌐 Moodle "President" Theme 🎓

The **President** theme for Moodle is a premium, modern, and highly customizable theme designed exclusively for **President University** 🏛️. Built on top of Moodle's **Boost** engine, it transforms the digital learning experience with elegance, efficiency, and a focus on accessibility. 🚀

## 🌟 Key Features

### 🎨 Modern Aesthetics & Customization
- **Dark Mode Support**: Seamlessly switch between Light, Dark, and System modes.
- **Custom Branding**: Upload unique logos for both Light and Dark modes, and customize your site's favicon.
- **Advanced Typography**: Choose from a curated list of Google Fonts including Poppins, Roboto, Inter, and more.
- **Color Control**: Full control over brand colors and secondary menu accents.
- **Navbar Versatility**: Select from Normal, Floating, or Sticky navigation bar styles to suit your site's flow.

### 🏠 Dynamic Frontpage
- **Interactive Slideshow**: Engagement-focused slider with customizable titles, captions, and dual Call-to-Action (CTA) buttons.
- **Faculty Showcases**: Dedicated sections to highlight different faculties or departments with icons and descriptions.
- **Global Recognition**: A professional logo carousel to display university partnerships and accreditations.
- **Live Site Statistics**: Display real-time numbers of active users and available courses to showcase site vitality.
- **Integrated FAQ**: A built-in, easy-to-manage FAQ section to help users find answers quickly.

### ♿ Enhanced Accessibility
- **Accessibility Toolbar**: Empower users with tools to adjust font sizes and reset styles.
- **Inclusive Typography**: Built-in support for **Dyslexic fonts** to improve readability for all learners.
- **High Contrast Modes**: Multiple contrast options to assist users with visual impairments.

### 📚 Course Experience
- **Optimized Layouts**: Clean, focused layouts for courses with toggleable course indexes.
- **Teacher Visibility**: Option to show or hide teacher profiles on course cards for a cleaner look.
- **Breadcrumb Navigation**: Choice between modern or classic breadcrumb styles.

### 🛠️ Advanced Integrations
- **Dynamic Guest Pages Manager**: Create up to 10 customizable pages (About, Programs, FAQ, etc.) with a dedicated settings manager.
- **Automatic Folder Routing**: No `.htaccess` needed! The theme automatically creates physical directories for your custom pages to ensure 100% stable **Pretty URLs** (e.g., `/programs/`, `/faq/`).
- **Automatic Slugification**: Page titles are automatically converted into URL-friendly slugs.
- **Premium UI Components**: Pre-styled "Custom Cards" ready to use in Moodle's RichText editor (TinyMCE/Atto).
- **Performance Optimized**: Removed heavy preloaders to ensure lightning-fast page transitions.
- **Analytics Ready**: Native support for **Google Analytics V4**.
- **Developer Friendly**: Inject custom SCSS directly from the admin settings.

---

## 🎨 Using Premium Components in Editor

To maintain a high-end look on your custom pages, you can use the **Premium Custom Cards** directly in TinyMCE. Switch to **HTML mode (`<>`)** and paste the following snippet:

```html
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="custom-card">
            <div class="card-icon"><i class="fas fa-briefcase"></i></div>
            <h4 class="card-title">Card Title</h4>
            <p class="card-text">Your professional description here.</p>
        </div>
    </div>
</div>
```

*The theme automatically handles Light and Dark mode styling for these components!*

---

## 👨‍💻 Developed and Maintained by

**Septian Dwi Cahyo**  
- 🛠️ **GitHub**: [github.com/septiandwica](https://github.com/septiandwica)  
- 💼 **LinkedIn**: [linkedin.com/in/septiandwica](https://www.linkedin.com/in/septiandwica)  
- 🌐 **Personal Website**: [samastanuswantara.com](https://samastanuswantara.com)  

**📍 Location**: Banyuwangi, Jawa Timur, Indonesia  
**👨‍🎨 Profession**: Full Stack Developer, UI/UX Designer, and Content Creator

---

## ⚙️ Installation

### 🔍 Method 1: Cloning the Repository
1. Navigate to your Moodle `theme` directory.
2. Run the following command:
    ```bash
    git clone https://github.com/septiandwica/president.git
    ```
3. Go to **Site Administration > Notifications** to complete the installation.

### 📥 Method 2: Manual Installation
1. Download the latest release from the [GitHub repository](https://github.com/septiandwica/president).
2. Extract and move the `president` folder into your Moodle `theme` directory.
3. Go to **Site Administration > Notifications** to complete the installation.

> [!IMPORTANT]
> This theme requires the default **Boost** theme to be installed and active for proper functionality.

---

## 🛑 License

This theme is open-source and available for use and modification under the [GNU General Public License v3](https://www.gnu.org/licenses/gpl-3.0.html).
