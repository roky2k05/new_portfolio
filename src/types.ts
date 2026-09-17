export type ProjectCategory = 'All' | 'Web Development' | 'Graphic Design' | 'UI/UX';

export interface Project {
  id: string;
  title: string;
  category: 'Web Development' | 'Graphic Design' | 'UI/UX';
  description: string;
  fullDescription?: string;
  technologies: string[];
  image: string;
  githubUrl?: string;
  liveUrl?: string;
  isPlaceholder?: boolean;
  featured?: boolean;
  highlights?: string[];
}

export type DesignCategory = 'All' | 'Logo Design' | 'Poster' | 'Social Media' | 'Branding' | 'Typography' | 'Creative Artwork';

export interface DesignItem {
  id: string;
  title: string;
  category: 'Logo Design' | 'Poster' | 'Social Media' | 'Branding' | 'Typography' | 'Creative Artwork';
  image: string;
  description: string;
  tools: string[];
  aspectRatio?: 'landscape' | 'portrait' | 'square';
}

export interface EducationItem {
  id: string;
  year: string;
  institution: string;
  title: string;
  status: 'Completed' | 'Currently Studying' | 'Future Goal';
  description: string;
  highlights: string[];
  badgeColor?: string;
}

export interface SkillItem {
  name: string;
  category: 'Development' | 'Design';
  proficiency: 'Learning' | 'Intermediate' | 'Advanced';
  description: string;
  iconName: string;
}

export interface ServiceItem {
  id: string;
  number: string;
  title: string;
  description: string;
  deliverables: string[];
  icon: string;
}

export interface ProcessStep {
  step: string;
  title: string;
  description: string;
  deliverable: string;
}

export interface Testimonial {
  id: string;
  name: string;
  role: string;
  organization: string;
  content: string;
  avatar: string;
  isSample: boolean;
}

export interface BlogPost {
  id: string;
  title: string;
  category: 'Web Development' | 'Graphic Design' | 'Technology' | 'Learning' | 'Projects';
  readTime: string;
  date: string;
  excerpt: string;
  content: string;
  image: string;
}

export interface ContactMessage {
  id: string;
  name: string;
  email: string;
  phone?: string;
  subject: string;
  message: string;
  status: 'Unread' | 'Read' | 'Replied';
  createdAt: string;
}

export interface SocialLink {
  platform: string;
  url: string;
  icon: string;
  isActive: boolean;
  username?: string;
}

export interface PricingTier {
  id: string;
  title: string;
  idealFor: string;
  features: string[];
  isHighlighted?: boolean;
}

export interface FAQItem {
  question: string;
  answer: string;
}
