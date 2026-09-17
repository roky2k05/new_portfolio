import {
  Project,
  DesignItem,
  EducationItem,
  SkillItem,
  ServiceItem,
  ProcessStep,
  Testimonial,
  BlogPost,
  SocialLink,
  PricingTier,
  FAQItem,
  ContactMessage,
} from '../types';

export const PERSONAL_INFO = {
  name: 'Rasindu Nawod',
  title: 'Web Developer | Graphic Designer',
  shortIntro:
    'I am Rasindu Nawod, a passionate Web Developer and Graphic Designer from Sri Lanka, focused on creating modern websites, creative visual designs and digital experiences.',
  headline: 'Turning Ideas Into\nDigital Experiences.',
  supportingText:
    'I create modern websites and creative visual designs that combine technology, functionality and aesthetics.',
  location: 'Sri Lanka | Matara | Akuressa',
  locationShort: 'Matara, Akuressa, Sri Lanka',
  nationality: 'Sri Lankan',
  phone: '+94 74 386 9265',
  whatsapp: '+94 74 386 9265',
  whatsappUrl: 'https://wa.me/94743869265?text=Hello%20Rasindu,%20I%20visited%20your%20portfolio!',
  email: 'razindunawod@gmail.com',
  educationShort: 'ICBT Campus (CSE Diploma)',
  statusShort: 'Currently Studying & Available for Projects',
  cvPath: '/assets/cv/Rasindu-Nawod-CV.pdf',
};

export const SOCIAL_LINKS: SocialLink[] = [
  {
    platform: 'GitHub',
    url: 'https://github.com/roky2k05',
    icon: 'github',
    isActive: true,
    username: '@roky2k05',
  },
  {
    platform: 'LinkedIn',
    url: 'https://www.linkedin.com/in/rasindu-nawod-148901374',
    icon: 'linkedin',
    isActive: true,
    username: 'Rasindu Nawod',
  },
  {
    platform: 'WhatsApp',
    url: 'https://wa.me/94743869265',
    icon: 'whatsapp',
    isActive: true,
    username: '+94 74 386 9265',
  },
  {
    platform: 'Instagram',
    url: 'https://www.instagram.com/lex_frost2k5?stkn=dmloMGtkc2RmZWIz',
    icon: 'instagram',
    isActive: true,
    username: '@rasindunawod',
  },
  {
    platform: 'Facebook',
    url: 'https://www.facebook.com/share/1F6N9ALqmG/',
    icon: 'facebook',
    isActive: true,
    username: 'Rasindu Nawod',
  },
  {
    platform: 'TikTok',
    url: 'https://www.tiktok.com/@rokiya2k?_r=1&_d=eghhldf7b1bdcf&sec_uid=MS4wLjABAAAA9Fc8bjJeZgg20lwBvRADfJKQpJKMRB_UvsZKLhxLenI0rBAqYLucldlVJOKP4AfY&share_author_id=7237487704039982085&sharer_language=en&source=h5_m&u_code=e85lf7kg2c73c5&timestamp=1789668068&user_id=7237487704039982085&sec_user_id=MS4wLjABAAAA9Fc8bjJeZgg20lwBvRADfJKQpJKMRB_UvsZKLhxLenI0rBAqYLucldlVJOKP4AfY&item_author_type=1&utm_source=copy&utm_campaign=client_share&utm_medium=android&share_iid=7685691593941632788&share_link_id=55482e22-81d5-4931-8ef4-c1ba7cb431da&share_app_id=1233&ugbiz_name=ACCOUNT&ug_btm=b8727%2Cb7360&social_share_type=5&enable_checksum=1',
    icon: 'tiktok',
    isActive: true,
    username: '@rasindunawod',
  },
];

export const EDUCATION_DATA: EducationItem[] = [
  {
    id: 'edu-1',
    year: '2024',
    institution: 'Rahula College, Matara',
    title: 'Completed School Education',
    status: 'Completed',
    description:
      'Completed secondary schooling at the prestigious Rahula College in Matara, developing strong mathematical problem solving, analytical thinking, and foundational leadership.',
    highlights: [
      'G.C.E. Advanced Level examinations completed in 2024',
      'Active participation in school technology & ICT activities',
      'Solid foundations in logic and mathematics',
    ],
    badgeColor: 'emerald',
  },
  {
    id: 'edu-2',
    year: '2024',
    institution: 'IMS Campus',
    title: 'Completed Graphic Design Course',
    status: 'Completed',
    description:
      'Mastered visual design principles, color theory, vector manipulation, typography, and professional asset preparation using industry-standard Adobe Creative Cloud applications.',
    highlights: [
      'Adobe Illustrator vector art, brand identity & logo design',
      'Adobe Photoshop photo compositing & digital artwork',
      'Print & digital layout rules, typography & composition',
    ],
    badgeColor: 'rose',
  },
  {
    id: 'edu-3',
    year: 'Current',
    institution: 'ICBT Campus',
    title: 'Diploma in Computer and Software Engineering',
    status: 'Currently Studying',
    description:
      'Undergoing comprehensive formal higher education in computer science, software engineering architectures, database modeling (MySQL), web technologies (PHP, JS), and object-oriented programming (Java).',
    highlights: [
      'Full-stack web development: PHP 8+, JavaScript, MySQL, HTML5/CSS3',
      'Object-Oriented Programming principles with Java',
      'Database design, relational normalization & SQL queries',
      'Software engineering lifecycle and agile development',
    ],
    badgeColor: 'sky',
  },
  {
    id: 'edu-4',
    year: 'Future',
    institution: 'Professional Journey',
    title: 'Full-Stack Development & Creative Design',
    status: 'Future Goal',
    description:
      'Aspiring to create modern web platforms, high-performance web applications, and distinctive digital brand experiences for local and international clients.',
    highlights: [
      'Continuous learning of modern frontend ecosystems',
      'Exploring robust backend systems and cloud deployment',
      'Bridging technical coding precision with graphic design elegance',
    ],
    badgeColor: 'purple',
  },
];

export const SKILLS_DATA: SkillItem[] = [
  // Development
  {
    name: 'HTML5',
    category: 'Development',
    proficiency: 'Advanced',
    description: 'Semantic markup, accessible structures, SEO-friendly layout, and clean DOM trees.',
    iconName: 'code',
  },
  {
    name: 'CSS3',
    category: 'Development',
    proficiency: 'Advanced',
    description: 'Modern flexbox, grid, animations, responsive media queries, and clean variables.',
    iconName: 'palette',
  },
  {
    name: 'JavaScript',
    category: 'Development',
    proficiency: 'Intermediate',
    description: 'ES6+ syntax, DOM manipulation, asynchronous AJAX/Fetch API, and interactive UI logic.',
    iconName: 'file-code',
  },
  {
    name: 'PHP 8+',
    category: 'Development',
    proficiency: 'Intermediate',
    description: 'Server-side scripting, PDO database operations, authentication, routing, and form handling.',
    iconName: 'server',
  },
  {
    name: 'Tailwind CSS',
    category: 'Development',
    proficiency: 'Learning',
    description: 'Utility-first rapid prototyping, responsive layouts, design tokens, and dark mode.',
    iconName: 'wind',
  },
  {
    name: 'Java',
    category: 'Development',
    proficiency: 'Learning',
    description: 'Object-oriented programming concepts, algorithms, class design, and problem solving.',
    iconName: 'coffee',
  },

  // Design
  {
    name: 'Adobe Illustrator',
    category: 'Design',
    proficiency: 'Intermediate',
    description: 'Vector graphics, custom logo marks, iconography, branding kits, and typography layout.',
    iconName: 'pen-tool',
  },
  {
    name: 'Adobe Photoshop',
    category: 'Design',
    proficiency: 'Advanced',
    description: 'Creative posters, social media banners, photo manipulation, mockups, and digital art.',
    iconName: 'image',
  },
];

export const STATS_DATA = [
  { label: 'Programming Skills', value: '6', suffix: '', note: 'HTML, CSS, JS, PHP, Java, Tailwind' },
  { label: 'Design Tools', value: '2', suffix: '+', note: 'Illustrator, Photoshop & UI' },
  { label: 'Completed Studies', value: '2024', suffix: '', note: 'Rahula College & IMS Campus' },
  { label: 'Current Studies', value: 'ICBT', suffix: '', note: 'Software Engineering Diploma' },
];

export const SERVICES_DATA: ServiceItem[] = [
  {
    id: 'service-1',
    number: '01',
    title: 'Web Development',
    description: 'Modern responsive websites built using clean HTML5, CSS3, JavaScript, PHP 8+ and MySQL databases with optimal speed and security.',
    deliverables: [
      'Semantic & SEO-optimized HTML5',
      'PHP server-side logic & database integration',
      'Cross-browser and multi-device compatibility',
      'Fast loading speeds & clean modular code',
    ],
    icon: 'globe',
  },
  {
    id: 'service-2',
    number: '02',
    title: 'Web Design',
    description: 'Clean, responsive and user-friendly website interfaces tailored for an intuitive user journey and engaging visual appeal.',
    deliverables: [
      'Modern responsive layouts',
      'Cohesive visual themes and typography',
      'Mobile-first design principles',
      'Intuitive navigation and call-to-actions',
    ],
    icon: 'layout',
  },
  {
    id: 'service-3',
    number: '03',
    title: 'Graphic Design',
    description: 'Creative visual designs crafted in Adobe Photoshop and Adobe Illustrator for brands, campaigns, events, and businesses.',
    deliverables: [
      'High-resolution vector illustrations',
      'Brand logo design & visual marks',
      'Marketing flyers, banners & posters',
      'Ready-to-print & digital export formats',
    ],
    icon: 'pen-tool',
  },
  {
    id: 'service-4',
    number: '04',
    title: 'UI Design',
    description: 'Modern user interface concepts for websites and digital products focusing on balanced aesthetics, hierarchy, and interaction.',
    deliverables: [
      'High-fidelity screen layouts',
      'Component design systems & color palettes',
      'Micro-interaction concepts',
      'Developer-friendly design handoffs',
    ],
    icon: 'sparkles',
  },
  {
    id: 'service-5',
    number: '05',
    title: 'Portfolio Websites',
    description: 'Professional personal and business portfolio websites designed to highlight individual skills, achievements, and case studies.',
    deliverables: [
      'Custom personal branding theme',
      'Interactive project showcases & galleries',
      'Resume/CV download integration',
      'Direct contact forms & social integrations',
    ],
    icon: 'user-check',
  },
  {
    id: 'service-6',
    number: '06',
    title: 'Landing Pages',
    description: 'Modern conversion-focused landing pages engineered to captivate visitors, present products clearly, and encourage action.',
    deliverables: [
      'Compelling hero sections & value propositions',
      'Persuasive call-to-action buttons',
      'Lightweight, ultra-fast performance',
      'Contact and inquiry capture workflows',
    ],
    icon: 'rocket',
  },
];

export const PROCESS_STEPS: ProcessStep[] = [
  {
    step: '01',
    title: 'Requirement',
    description: "Understand the client's requirements, goals, target audience, and functional expectations in depth.",
    deliverable: 'Scope definition & technical plan',
  },
  {
    step: '02',
    title: 'Sketch',
    description: 'Create an initial structural wireframe, information architecture, and layout layout blueprint.',
    deliverable: 'Visual wireframes & layout concept',
  },
  {
    step: '03',
    title: 'Design',
    description: 'Develop the visual design, typography, color palette, and interactive user experience.',
    deliverable: 'High-fidelity UI mockups & graphic assets',
  },
  {
    step: '04',
    title: 'Development',
    description: 'Build the responsive website or digital product with clean, semantic code and robust logic.',
    deliverable: 'Functional code & responsive templates',
  },
  {
    step: '05',
    title: 'Testing',
    description: 'Test responsiveness across 320px to 1920px viewports, browser compatibility, and form workflows.',
    deliverable: 'Quality assurance & performance check',
  },
  {
    step: '06',
    title: 'Final Files',
    description: 'Deliver the completed project files, database schemas, documentation, and deployment guides.',
    deliverable: 'Production deployment & source delivery',
  },
];

export const PROJECTS_DATA: Project[] = [
  {
    id: 'proj-1',
    title: 'ICBT Campus Portal & Academic Showcase',
    category: 'Web Development',
    description: 'A responsive academic website mockup featuring course modules, student inquiry system, and institutional information.',
    fullDescription: 'Developed as part of academic learning at ICBT Campus. Implements relational database structures for course catalogs, student query routing via PHP PDO, and responsive styling.',
    technologies: ['HTML5', 'CSS3', 'JavaScript', 'PHP', 'MySQL'],
    image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80',
    githubUrl: 'https://github.com/rasindunawod/icbt-campus-web',
    liveUrl: '#',
    isPlaceholder: true,
    featured: true,
    highlights: [
      'Course catalog with category filtering',
      'Database-driven inquiry contact form with PDO',
      'Responsive design across mobile and desktop',
      'Built in alignment with diploma project curriculum',
    ],
  },
  {
    id: 'proj-2',
    title: 'Personal Portfolio & Brand Showcase',
    category: 'Web Development',
    description: 'The personal website for Rasindu Nawod combining modern web engineering with graphic design aesthetics.',
    fullDescription: 'Crafted to showcase web development and graphic design expertise. Features dark/light mode switching, responsive timeline, design gallery lightbox, contact message database handling, and clean aesthetics.',
    technologies: ['HTML5', 'Tailwind CSS', 'JavaScript', 'PHP 8+', 'MySQL'],
    image: 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=1200&q=80',
    githubUrl: 'https://github.com/rasindunawod/portfolio',
    liveUrl: '#',
    isPlaceholder: false,
    featured: true,
    highlights: [
      'Dual developer and graphic designer persona integration',
      'Masonry design gallery with interactive lightbox',
      'PHP PDO contact backend with MySQL storage',
      'Dark/light theme persistence in localStorage',
    ],
  },
  {
    id: 'proj-3',
    title: 'Creative Graphic Design Collection',
    category: 'Graphic Design',
    description: 'Curated collection of logos, promotional posters, and branding identity assets created in Illustrator and Photoshop.',
    fullDescription: 'Visual art showcase highlighting branding exploration, vector logos, sports & cultural event posters, and digital typography developed during the IMS Campus course and creative practice.',
    technologies: ['Adobe Illustrator', 'Adobe Photoshop', 'Vector Art', 'Typography'],
    image: 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=1200&q=80',
    liveUrl: '#',
    isPlaceholder: true,
    featured: true,
    highlights: [
      'Original vector brand logos & emblem marks',
      'High-resolution promotional event flyers & posters',
      'Carefully balanced color harmonies and hierarchy',
      'Commercial-ready CMYK and digital RGB exports',
    ],
  },
  {
    id: 'proj-4',
    title: 'Sri Lanka Travel & Heritage Landing Page',
    category: 'UI/UX',
    description: 'Modern travel landing page concept celebrating the coastal beauty of Matara and Sri Lankan heritage.',
    fullDescription: 'An exploratory UI/UX concept emphasizing stunning imagery, bold typography, intuitive booking inquiry forms, and micro-interactions.',
    technologies: ['UI Design', 'Figma', 'HTML5', 'Tailwind CSS'],
    image: 'https://images.unsplash.com/photo-1588598198321-9735fd52455b?auto=format&fit=crop&w=1200&q=80',
    liveUrl: '#',
    isPlaceholder: true,
    featured: false,
    highlights: [
      'Hero banner celebrating southern coastal destinations',
      'Interactive card carousel for travel experiences',
      'Accessible contrast and clean white space',
    ],
  },
  {
    id: 'proj-5',
    title: 'Clean E-Commerce UI Concept',
    category: 'UI/UX',
    description: 'Minimalist e-commerce interface with clean card grids, product filtering, and quick checkout modals.',
    fullDescription: 'Focused on reducing friction in online shopping with clear visual hierarchy, prominent calls to action, and swift mobile interactions.',
    technologies: ['UI Design', 'CSS Grid', 'JavaScript'],
    image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80',
    liveUrl: '#',
    isPlaceholder: true,
    featured: false,
    highlights: [
      'Modern product card hover states',
      'Filterable categories with smooth layout updates',
      'Clean typography and pricing labels',
    ],
  },
  {
    id: 'proj-6',
    title: 'Local Business Website Concept',
    category: 'Web Development',
    description: 'A multi-page responsive website prototype for local service businesses in Matara with working inquiry form.',
    fullDescription: 'Engineered with lightweight HTML/CSS/PHP, ensuring fast loading on mobile networks and clear presentation of services and operating hours.',
    technologies: ['HTML5', 'CSS3', 'PHP', 'JavaScript'],
    image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80',
    githubUrl: 'https://github.com/rasindunawod/local-business-web',
    liveUrl: '#',
    isPlaceholder: true,
    featured: false,
    highlights: [
      'Optimized for mobile viewing and speed',
      'PHP contact form with client and server validation',
      'Custom Google Maps and location directions embed',
    ],
  },
];

export const DESIGN_GALLERY_DATA: DesignItem[] = [
  {
    id: 'des-1',
    title: 'RN Monogram Identity Mark',
    category: 'Logo Design',
    image: 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=800&q=80',
    description: 'Geometric monogram logo balancing sharp tech angles with smooth organic curves. Crafted in Adobe Illustrator.',
    tools: ['Adobe Illustrator', 'Vector Pen Tool'],
    aspectRatio: 'square',
  },
  {
    id: 'des-2',
    title: 'Vibrant Tech Summit Poster',
    category: 'Poster',
    image: 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=800&q=80',
    description: 'Promotional event poster featuring high-contrast typography, futuristic color gradients, and dynamic layout.',
    tools: ['Adobe Photoshop', 'Adobe Illustrator'],
    aspectRatio: 'portrait',
  },
  {
    id: 'des-3',
    title: 'Minimalist Brand Identity Suite',
    category: 'Branding',
    image: 'https://images.unsplash.com/photo-1600132806370-bf17e65e942f?auto=format&fit=crop&w=800&q=80',
    description: 'Stationery and brand mockup including business card, letterhead, and color swatch guidelines.',
    tools: ['Adobe Illustrator', 'Photoshop Mockup'],
    aspectRatio: 'landscape',
  },
  {
    id: 'des-4',
    title: 'Social Media Campaign Kit',
    category: 'Social Media',
    image: 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80',
    description: 'Consistent Instagram post and story templates crafted for digital marketing promotions.',
    tools: ['Adobe Photoshop'],
    aspectRatio: 'square',
  },
  {
    id: 'des-5',
    title: 'Expressive Typography Art',
    category: 'Typography',
    image: 'https://images.unsplash.com/photo-1541701494587-cb58502866ab?auto=format&fit=crop&w=800&q=80',
    description: 'Exploration of custom letterforms, glyph rhythm, and dimensional shadows creating visual impact.',
    tools: ['Adobe Illustrator'],
    aspectRatio: 'portrait',
  },
  {
    id: 'des-6',
    title: 'Abstract Digital Vector Illustration',
    category: 'Creative Artwork',
    image: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=800&q=80',
    description: 'Dynamic composition of geometric shapes, mesh gradients, and flowing bezier curves.',
    tools: ['Adobe Illustrator', 'Adobe Photoshop'],
    aspectRatio: 'landscape',
  },
];

export const PRICING_TIERS: PricingTier[] = [
  {
    id: 'tier-1',
    title: 'Basic Website',
    idealFor: 'Personal profiles, basic single-page sites, or simple announcements.',
    features: [
      'Single-page clean responsive layout',
      'HTML5, CSS3 & JavaScript architecture',
      'Contact form & WhatsApp click-to-chat',
      'Mobile & desktop responsive testing',
      'Basic SEO meta tags',
      'Source files delivery',
    ],
    isHighlighted: false,
  },
  {
    id: 'tier-2',
    title: 'Custom Website',
    idealFor: 'Multi-page business or service websites with database integration.',
    features: [
      'Multi-page structure (Home, About, Services, Contact)',
      'PHP 8+ and MySQL backend integration',
      'Contact message storage & validation',
      'Modern Tailwind CSS design system',
      'Interactive UI elements & animations',
      'Admin dashboard for messages',
    ],
    isHighlighted: true,
  },
  {
    id: 'tier-3',
    title: 'Portfolio Website',
    idealFor: 'Creatives, developers, photographers, and freelancers.',
    features: [
      'Tailored personal branding & identity',
      'Filterable project & design showcases',
      'Interactive lightbox gallery',
      'Dark / Light theme switcher',
      'CV download functionality',
      'Social media integration',
    ],
    isHighlighted: false,
  },
  {
    id: 'tier-4',
    title: 'Graphic Design',
    idealFor: 'Logos, branding packages, posters, and marketing collateral.',
    features: [
      'Logo design with vector source files (.AI, .EPS, .SVG)',
      'Social media promotional post templates',
      'High-resolution event / business posters',
      'Print-ready CMYK & digital RGB exports',
      'Typography & color palette guidance',
      'Multiple revision rounds',
    ],
    isHighlighted: false,
  },
  {
    id: 'tier-5',
    title: 'Custom Project',
    idealFor: 'Tailored solutions combining custom development & graphic design.',
    features: [
      'Comprehensive discovery & requirement planning',
      'Custom UI/UX wireframes & design mockups',
      'Full-stack development with PHP & MySQL',
      'End-to-end testing across all viewports',
      'Database schema setup & documentation',
      'Post-launch support & consultation',
    ],
    isHighlighted: false,
  },
];

export const TESTIMONIALS_DATA: Testimonial[] = [
  {
    id: 'test-1',
    name: 'Navod Nawarathna',
    role: 'Lecturer in Software Engineering',
    organization: 'ICBT Campus (Sample Mentor Feedback)',
    content:
      'Rasindu demonstrates commendable enthusiasm for clean coding standards and interface aesthetics. His eagerness to blend frontend responsiveness with backend database architecture reflects strong potential.',
    avatar: 'https://media.licdn.com/dms/image/v2/D5603AQGWpT_AgdLU2A/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1730312666347?e=1791417600&v=beta&t=O_YQA_6VPnv_KlcCU-j1-nvMvaI922udkYgXDnOYq30',
    isSample: true,
  },
  {
    id: 'test-2',
    name: 'Paramee Lakshitha',
    role: 'Senior Graphic Designer',
    organization: 'Creative Studio (Sample Review)',
    content:
      'The composition and vector mastery shown in Rasindu’s graphic design work stand out. He understands color theory, typography hierarchy, and brand cohesion very well for an emerging creative.',
    avatar: 'data:image/jpeg;base64,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',
    isSample: true,
  },
 
];

export const BLOG_POSTS: BlogPost[] = [
  {
    id: 'blog-1',
    title: 'Why Web Developers Should Learn Graphic Design Principles',
    category: 'Web Development',
    readTime: '4 min read',
    date: 'Sep 2024',
    excerpt: 'How understanding typography, color harmony, and visual hierarchy transforms a basic programmer into an impactful digital creator.',
    content: `When building websites, code functionality is only half the equation. If an interface is confusing or visually unappealing, users leave before appreciating the backend logic.

By learning graphic design—understanding the rule of thirds, optical balance, mathematical line heights, and typography pairing—a web developer can build interfaces that feel instinctive and natural to navigate.

In my journey studying Software Engineering at ICBT Campus alongside Graphic Design at IMS Campus, this dual perspective allows me to bridge technical structure with visual artistry.`,
    image: 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&w=800&q=80',
  },
  {
    id: 'blog-2',
    title: 'Mastering Vector Graphics in Adobe Illustrator for the Web',
    category: 'Graphic Design',
    readTime: '5 min read',
    date: 'Aug 2024',
    excerpt: 'Key tips for preparing clean SVG icons and brand assets that scale cleanly across all screens without bloating file sizes.',
    content: `Scalable Vector Graphics (SVG) are the gold standard for modern website logos, illustrations, and icons. Unlike pixel raster images, vectors remain crisp on ultra-high-resolution Retina displays while retaining tiny byte sizes.

When exporting from Adobe Illustrator:
1. Clean up unused anchor points using the Object > Path > Simplify tool.
2. Convert strokes to outlines where exact stroke weight preservation is critical.
3. Optimize viewBox attributes for responsive container embedding.`,
    image: 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=800&q=80',
  },
  {
    id: 'blog-3',
    title: 'Building Secure PHP & MySQL Forms: Prepared Statements & CSRF',
    category: 'Technology',
    readTime: '6 min read',
    date: 'Jul 2024',
    excerpt: 'A practical guide to securing PHP contact forms against SQL injection and cross-site request forgery.',
    content: `Never trust client-side validation alone. While JavaScript provides instant feedback to users, malicious actors can easily bypass browser checks.

Using PHP 8+ PDO with prepared statements ensures all parameters are treated strictly as data rather than executable SQL commands, completely neutralizing SQL injection vulnerabilities. Combining this with CSRF tokens and htmlspecialchars sanitization guarantees robust security.`,
    image: 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=800&q=80',
  },
];

export const FAQ_DATA: FAQItem[] = [
  {
    question: 'What services do you provide?',
    answer:
      'I specialize in Web Development (HTML5, CSS3, JavaScript, PHP 8+, MySQL), Web Design, UI Design, and Graphic Design (Logos, Posters, Social Media, Branding in Illustrator & Photoshop).',
  },
  {
    question: 'What technologies do you use?',
    answer:
      'For development: HTML5, CSS3, JavaScript, PHP 8+, MySQL, Java, and Tailwind CSS. For graphic and UI design: Adobe Illustrator, Adobe Photoshop, and modern vector tools.',
  },
  {
    question: 'Can you create a custom website for my business or portfolio?',
    answer:
      'Yes! I create customized, responsive websites tailored to your specific requirements, brand personality, and target audience, ensuring seamless performance across mobile, tablet, and desktop.',
  },
  {
    question: 'Do you provide graphic design services independently?',
    answer:
      'Yes, I create logo marks, brand identities, promotional posters, event flyers, and social media creative graphics ready for print or digital distribution.',
  },
  {
    question: 'How can I contact you?',
    answer:
      'You can reach me directly via the Contact Form on this website, call or message on WhatsApp (+94 74 123 4567), or connect through my social profiles on GitHub and LinkedIn.',
  },
  {
    question: 'How does the project process work?',
    answer:
      'I follow a structured 6-step workflow: 01 Requirement gathering, 02 Wireframe sketching, 03 Visual design, 04 Clean development, 05 Multi-device testing, and 06 Final file delivery with ongoing support.',
  },
];

export const INITIAL_MESSAGES: ContactMessage[] = [
  {
    id: 'msg-1',
    name: 'Kaveen Jayawardena',
    email: 'kaveen@example.com',
    phone: '+94 77 520 3445',
    subject: 'Inquiry: Modern Portfolio Website',
    message: 'Hello Rasindu, I saw your case studies and need a responsive portfolio for my architecture practice. Looking forward to discussing the project scope.',
    status: 'Unread',
    createdAt: '2026-09-15 14:30',
  },
  {
    id: 'msg-2',
    name: 'Dilshan Fernando',
    email: 'dilshan@creativepulse.lk',
    phone: '+94 71 987 6543',
    subject: 'Brand Identity & Logo Design Project',
    message: 'Hi Rasindu, we loved your vector typography work. Would love to collaborate on a full brand identity package for our new startup.',
    status: 'Replied',
    createdAt: '2026-09-12 09:15',
  },
];

