import React from 'react';
import { 
  ArrowUp, 
  MapPin, 
  Phone, 
  Mail, 
  MessageSquare, 
  ArrowRight,
  Sparkles,
  Heart
} from 'lucide-react';
import { PERSONAL_INFO, SOCIAL_LINKS } from '../data/portfolioData';

interface FooterProps {
  onOpenQuoteModal: () => void;
}

export const Footer: React.FC<FooterProps> = ({ onOpenQuoteModal }) => {
  const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  const quickLinks = [
    { name: 'Home', href: '#home' },
    { name: 'About', href: '#about' },
    { name: 'Skills', href: '#skills' },
    { name: 'Services', href: '#services' },
    { name: 'Projects', href: '#projects' },
    { name: 'Design Gallery', href: '#gallery' },
    { name: 'Education', href: '#education' },
    { name: 'Contact', href: '#contact' },
  ];

  return (
    <footer className="bg-neutral-950 text-neutral-300 relative overflow-hidden pt-16 pb-12 border-t border-neutral-900">
      
      {/* FINAL CTA BANNER */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20">
        <div className="relative rounded-3xl p-8 sm:p-14 bg-gradient-to-br from-neutral-900 via-neutral-900 to-neutral-800 border border-neutral-800 shadow-2xl overflow-hidden text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-8">
          
          <div className="relative z-10 max-w-xl">
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-500/10 text-rose-400 text-xs font-semibold tracking-wider uppercase mb-3 border border-rose-500/20">
              <Sparkles className="w-3.5 h-3.5" />
              <span>Available for New Projects</span>
            </div>
            <h2 className="text-3xl sm:text-4xl font-extrabold font-heading text-white tracking-tight mb-3">
              Have a project in mind?
            </h2>
            <p className="text-base text-neutral-300 leading-relaxed">
              Let's turn your idea into something amazing. From responsive web applications to brand identity and graphic design.
            </p>
          </div>

          <div className="relative z-10 flex flex-wrap items-center justify-center sm:justify-end gap-3 w-full sm:w-auto">
            <button
              onClick={onOpenQuoteModal}
              id="cta-start-project-btn"
              className="px-6 py-3.5 rounded-xl font-semibold text-sm text-white bg-rose-600 hover:bg-rose-700 shadow-lg shadow-rose-600/25 transition-all duration-200 cursor-pointer active:scale-95"
            >
              Start a Project
            </button>
            <a
              href="#contact"
              id="cta-contact-me-btn"
              className="px-6 py-3.5 rounded-xl font-semibold text-sm text-neutral-200 bg-neutral-800 hover:bg-neutral-700 transition-all duration-200 cursor-pointer active:scale-95 border border-neutral-700"
            >
              Contact Me
            </a>
          </div>

          {/* Decorative subtle gradient */}
          <div className="absolute top-0 right-0 w-80 h-80 bg-rose-500/10 rounded-full blur-3xl pointer-events-none" />
        </div>
      </div>

      {/* FOOTER MAIN CONTENT */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-neutral-800">
          
          {/* Brand Col */}
          <div className="md:col-span-5 space-y-4">
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 rounded-xl bg-neutral-900 border border-neutral-700 flex items-center justify-center font-bold text-lg text-white">
                <span>R</span>
                <span className="text-rose-500">N</span>
              </div>
              <div>
                <h3 className="text-xl font-bold font-heading text-white">
                  {PERSONAL_INFO.name}
                </h3>
                <p className="text-xs text-rose-400 font-medium">
                  {PERSONAL_INFO.title}
                </p>
              </div>
            </div>

            <p className="text-sm text-neutral-400 leading-relaxed max-w-sm">
              {PERSONAL_INFO.shortIntro}
            </p>

            <div className="flex items-center gap-2 text-xs text-neutral-400">
              <MapPin className="w-4 h-4 text-rose-500 shrink-0" />
              <span>{PERSONAL_INFO.location}</span>
            </div>
          </div>

          {/* Quick Links */}
          <div className="md:col-span-3 space-y-3">
            <h4 className="text-xs font-bold uppercase tracking-wider text-white">
              Navigation
            </h4>
            <div className="grid grid-cols-2 gap-2 text-xs">
              {quickLinks.map((link) => (
                <a
                  key={link.name}
                  href={link.href}
                  className="text-neutral-400 hover:text-white transition-colors"
                >
                  {link.name}
                </a>
              ))}
            </div>
          </div>

          {/* Contact Details & Social */}
          <div className="md:col-span-4 space-y-4">
            <h4 className="text-xs font-bold uppercase tracking-wider text-white">
              Direct Contact
            </h4>
            
            <div className="space-y-2 text-xs text-neutral-400">
              <div className="flex items-center gap-2">
                <Phone className="w-3.5 h-3.5 text-rose-500" />
                <span>Phone / WhatsApp: {PERSONAL_INFO.phone}</span>
              </div>
              <div className="flex items-center gap-2">
                <Mail className="w-3.5 h-3.5 text-rose-500" />
                <span>Email: {PERSONAL_INFO.email}</span>
              </div>
            </div>

            {/* Social Icons */}
            <div className="flex flex-wrap gap-2 pt-2">
              {SOCIAL_LINKS.map((link) => (
                <a
                  key={link.platform}
                  href={link.url}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="px-2.5 py-1 rounded-lg text-xs bg-neutral-900 border border-neutral-800 text-neutral-400 hover:text-white hover:border-neutral-700 transition-colors"
                  title={link.platform}
                >
                  {link.platform}
                </a>
              ))}
            </div>
          </div>

        </div>

        {/* BOTTOM COPYRIGHT */}
        <div className="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-neutral-500">
          <p>© 2026 Rasindu Nawod. All Rights Reserved.</p>

          <p className="flex items-center gap-1">
            <span>Designed & Engineered with passion from Sri Lanka</span>
          </p>

          <button
            onClick={scrollToTop}
            id="scroll-to-top-btn"
            className="flex items-center gap-1.5 text-neutral-400 hover:text-white transition-colors cursor-pointer"
          >
            <span>Back to Top</span>
            <ArrowUp className="w-4 h-4" />
          </button>
        </div>

      </div>
    </footer>
  );
};
