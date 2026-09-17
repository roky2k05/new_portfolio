import React, { useState, useEffect } from 'react';
import { Navbar } from './components/Navbar';
import { Hero } from './components/Hero';
import { AboutMe } from './components/AboutMe';
import { EducationTimeline } from './components/EducationTimeline';
import { SkillsSection } from './components/SkillsSection';
import { ServicesSection } from './components/ServicesSection';
import { WorkProcess } from './components/WorkProcess';
import { ProjectsShowcase } from './components/ProjectsShowcase';
import { DesignGallery } from './components/DesignGallery';
import { PricingSection } from './components/PricingSection';
import { TestimonialsSlider } from './components/TestimonialsSlider';
import { BlogSection } from './components/BlogSection';
import { FAQSection } from './components/FAQSection';
import { ContactSection } from './components/ContactSection';
import { Footer } from './components/Footer';
import { CvModal } from './components/CvModal';
import { QuoteModal } from './components/QuoteModal';
import { AdminModal } from './components/AdminModal';
import { SourceCodeModal } from './components/SourceCodeModal';
import { ContactMessage } from './types';
import { INITIAL_MESSAGES } from './data/portfolioData';

export default function App() {
  // Theme state
  const [darkMode, setDarkMode] = useState<boolean>(() => {
    const saved = localStorage.getItem('theme');
    if (saved) return saved === 'dark';
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
  });

  // Modal visibility states
  const [isCvOpen, setIsCvOpen] = useState(false);
  const [isQuoteOpen, setIsQuoteOpen] = useState(false);
  const [quoteServiceTitle, setQuoteServiceTitle] = useState('Web Development');
  const [isAdminOpen, setIsAdminOpen] = useState(false);
  const [isSourceCodeOpen, setIsSourceCodeOpen] = useState(false);

  // Messages database state with localStorage persistence
  const [messages, setMessages] = useState<ContactMessage[]>(() => {
    const saved = localStorage.getItem('rasindu_contact_messages');
    if (saved) {
      try {
        return JSON.parse(saved);
      } catch (e) {
        console.error('Failed to parse saved messages', e);
      }
    }
    return INITIAL_MESSAGES;
  });

  // Sync theme class
  useEffect(() => {
    if (darkMode) {
      document.documentElement.classList.add('dark');
      localStorage.setItem('theme', 'dark');
    } else {
      document.documentElement.classList.remove('dark');
      localStorage.setItem('theme', 'light');
    }
  }, [darkMode]);

  // Sync messages
  useEffect(() => {
    localStorage.setItem('rasindu_contact_messages', JSON.stringify(messages));
  }, [messages]);

  const toggleDarkMode = () => {
    setDarkMode(prev => !prev);
  };

  const handleSendMessage = async (msg: Omit<ContactMessage, 'id' | 'createdAt' | 'status'>): Promise<boolean> => {
    // Format timestamp
    const now = new Date();
    const formattedDate = now.toISOString().slice(0, 10) + ' ' + now.toTimeString().slice(0, 5);

    const newMessage: ContactMessage = {
      ...msg,
      id: 'msg-' + Date.now(),
      createdAt: formattedDate,
      status: 'Unread',
    };

    // Add to local state (instant update)
    setMessages(prev => [newMessage, ...prev]);
    return true;
  };

  const handleUpdateMessageStatus = (id: string, newStatus: 'Unread' | 'Read' | 'Replied') => {
    setMessages(prev =>
      prev.map(m => (m.id === id ? { ...m, status: newStatus } : m))
    );
  };

  const handleDeleteMessage = (id: string) => {
    setMessages(prev => prev.filter(m => m.id !== id));
  };

  const handleSelectServiceForQuote = (serviceTitle: string) => {
    setQuoteServiceTitle(serviceTitle);
    setIsQuoteOpen(true);
  };

  const handleScrollToContact = () => {
    const el = document.getElementById('contact');
    if (el) {
      el.scrollIntoView({ behavior: 'smooth' });
    }
  };

  const handleScrollToProjects = () => {
    const el = document.getElementById('projects');
    if (el) {
      el.scrollIntoView({ behavior: 'smooth' });
    }
  };

  return (
    <div className="min-h-screen bg-white dark:bg-[#0b0d13] text-neutral-900 dark:text-neutral-100 font-sans transition-colors duration-300 antialiased selection:bg-rose-500 selection:text-white">
      
      {/* Navbar */}
      <Navbar
        darkMode={darkMode}
        setDarkMode={setDarkMode}
        onOpenCv={() => setIsCvOpen(true)}
        onOpenAdmin={() => setIsAdminOpen(true)}
        onOpenSourceModal={() => setIsSourceCodeOpen(true)}
        unreadCount={messages.filter((m) => m.status === 'Unread').length}
      />

      {/* Main Content Sections */}
      <main>
        {/* Hero Section */}
        <Hero
          onOpenCv={() => setIsCvOpen(true)}
          onOpenQuoteModal={() => handleSelectServiceForQuote('Web Development')}
        />

        {/* About Me Section */}
        <AboutMe />

        {/* Education Timeline */}
        <EducationTimeline />

        {/* Skills & Metrics */}
        <SkillsSection />

        {/* Services */}
        <ServicesSection onSelectService={handleSelectServiceForQuote} />

        {/* Work Process */}
        <WorkProcess />

        {/* Projects Showcase */}
        <ProjectsShowcase />

        {/* Graphic Design Gallery */}
        <DesignGallery />

        {/* Services & Custom Quotation */}
        <PricingSection onOpenQuoteModal={(tierTitle) => handleSelectServiceForQuote(tierTitle || 'Custom Project')} />

        {/* Testimonials */}
        <TestimonialsSlider />

        {/* Blog & Tech Notes */}
        <BlogSection />

        {/* Frequently Asked Questions */}
        <FAQSection onOpenContact={handleScrollToContact} />

        {/* Contact Section */}
        <ContactSection
          onSendMessage={handleSendMessage}
        />
      </main>

      {/* Footer & Final CTA */}
      <Footer onOpenQuoteModal={() => handleSelectServiceForQuote('Custom Project')} />

      {/* Interactive Modals */}
      <CvModal
        isOpen={isCvOpen}
        onClose={() => setIsCvOpen(false)}
      />

      <QuoteModal
        isOpen={isQuoteOpen}
        onClose={() => setIsQuoteOpen(false)}
        serviceTitle={quoteServiceTitle}
        onSendMessage={handleSendMessage}
      />

      <AdminModal
        isOpen={isAdminOpen}
        onClose={() => setIsAdminOpen(false)}
        messages={messages}
        onUpdateStatus={handleUpdateMessageStatus}
        onDeleteMessage={handleDeleteMessage}
      />

      <SourceCodeModal
        isOpen={isSourceCodeOpen}
        onClose={() => setIsSourceCodeOpen(false)}
      />

    </div>
  );
}
