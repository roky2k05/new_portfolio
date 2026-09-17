import React, { useState, useEffect } from 'react';
import { 
  Menu, 
  X, 
  Sun, 
  Moon, 
  FileDown, 
  ArrowUpRight,
  ShieldCheck,
  FolderArchive,
  User,
  LogIn,
  UserPlus,
  LayoutDashboard,
  LogOut
} from 'lucide-react';
import { PERSONAL_INFO } from '../data/portfolioData';
import { UserAccount } from './ClientPortalModal';

interface NavbarProps {
  darkMode: boolean;
  setDarkMode: (value: boolean) => void;
  onOpenCv: () => void;
  onOpenAdmin: () => void;
  onOpenSourceModal: () => void;
  unreadCount: number;
  currentUser: UserAccount | null;
  onOpenLogin: () => void;
  onOpenRegister: () => void;
  onOpenDashboard: () => void;
  onLogout: () => void;
}

export const Navbar: React.FC<NavbarProps> = ({
  darkMode,
  setDarkMode,
  onOpenCv,
  onOpenAdmin,
  onOpenSourceModal,
  unreadCount,
  currentUser,
  onOpenLogin,
  onOpenRegister,
  onOpenDashboard,
  onLogout,
}) => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [activeSection, setActiveSection] = useState('home');

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 20);

      const sections = [
        'home', 
        'about', 
        'skills', 
        'services', 
        'how-i-work', 
        'projects', 
        'graphic-design', 
        'education', 
        'blog', 
        'faq', 
        'contact'
      ];
      const scrollPosition = window.scrollY + 200;

      for (const section of sections) {
        const el = document.getElementById(section);
        if (el) {
          const top = el.offsetTop;
          const height = el.offsetHeight;
          if (scrollPosition >= top && scrollPosition < top + height) {
            setActiveSection(section);
            break;
          }
        }
      }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const navLinks = [
    { name: 'Home', href: '#home' },
    { name: 'About', href: '#about' },
    { name: 'Skills', href: '#skills' },
    { name: 'Services', href: '#services' },
    { name: 'How I Work', href: '#how-i-work' },
    { name: 'Projects', href: '#projects' },
    { name: 'Graphic Design', href: '#graphic-design' },
    { name: 'Education', href: '#education' },
    { name: 'Blog', href: '#blog' },
    { name: 'FAQ', href: '#faq' },
    { name: 'Contact', href: '#contact' },
  ];

  return (
    <header
      id="main-navbar"
      className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
        isScrolled
          ? 'py-3 glass-panel border-b border-neutral-200/80 dark:border-neutral-800/80 shadow-sm'
          : 'py-4 bg-transparent'
      }`}
    >
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
        {/* Brand Logo */}
        <a
          href="#home"
          id="nav-logo"
          className="group flex items-center gap-2.5 focus:outline-none shrink-0"
        >
          <div className="w-9 h-9 rounded-xl bg-neutral-900 dark:bg-neutral-800 border border-neutral-700/40 flex items-center justify-center font-bold text-base text-white shadow-sm transition-transform duration-300 group-hover:scale-105">
            <span className="text-white">R</span>
            <span className="text-rose-500">N</span>
          </div>
          <div className="flex flex-col">
            <span className="font-heading font-bold text-sm sm:text-base tracking-tight text-neutral-900 dark:text-white leading-tight">
              {PERSONAL_INFO.name}
            </span>
            <span className="text-[10px] sm:text-[11px] font-medium text-neutral-500 dark:text-neutral-400 tracking-wider uppercase">
              Web Developer &bull; Graphic Designer
            </span>
          </div>
        </a>

        {/* Desktop Nav Links (Scrollable pill) */}
        <nav className="hidden xl:flex items-center gap-1 bg-neutral-100/80 dark:bg-neutral-900/80 border border-neutral-200/80 dark:border-neutral-800/80 px-2.5 py-1 rounded-full backdrop-blur-md">
          {navLinks.map((link) => {
            const isActive = activeSection === link.href.replace('#', '');
            return (
              <a
                key={link.name}
                href={link.href}
                id={`nav-link-${link.name.toLowerCase().replace(/\s+/g, '-')}`}
                className={`px-3 py-1 rounded-full text-xs font-medium transition-all duration-200 whitespace-nowrap ${
                  isActive
                    ? 'bg-white dark:bg-neutral-800 text-rose-600 dark:text-rose-400 font-semibold shadow-xs'
                    : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-neutral-800/50'
                }`}
              >
                {link.name}
              </a>
            );
          })}
        </nav>

        {/* Right Actions: Auth buttons, Dark Mode, CV Download, Source / Admin shortcuts */}
        <div className="hidden md:flex items-center gap-2 shrink-0">
          
          {/* USER AUTH CONDITIONAL STATE */}
          {currentUser ? (
            <div className="flex items-center gap-1.5 bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-full px-2 py-1">
              <button
                onClick={onOpenDashboard}
                id="nav-user-dashboard-btn"
                className="flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors"
              >
                <LayoutDashboard className="w-3.5 h-3.5" />
                <span>Dashboard</span>
              </button>
              <button
                onClick={onLogout}
                id="nav-user-logout-btn"
                title="Logout"
                className="p-1 rounded-full text-neutral-500 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors"
              >
                <LogOut className="w-3.5 h-3.5" />
              </button>
            </div>
          ) : (
            <div className="flex items-center gap-1.5">
              <button
                onClick={onOpenLogin}
                id="nav-login-btn"
                className="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
              >
                <LogIn className="w-3.5 h-3.5 text-neutral-500" />
                <span>Login</span>
              </button>
              <button
                onClick={onOpenRegister}
                id="nav-register-btn"
                className="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 border border-rose-200 dark:border-rose-900/40 transition-colors"
              >
                <UserPlus className="w-3.5 h-3.5" />
                <span>Register</span>
              </button>
            </div>
          )}

          {/* PHP Source / XAMPP Modal Trigger */}
          <button
            onClick={onOpenSourceModal}
            id="nav-php-package-btn"
            title="View Complete PHP & MySQL Codebase"
            className="flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl text-xs font-medium text-neutral-700 dark:text-neutral-300 bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 transition-colors border border-neutral-200 dark:border-neutral-700 cursor-pointer"
          >
            <FolderArchive className="w-3.5 h-3.5 text-amber-500" />
            <span className="hidden lg:inline">PHP Code</span>
          </button>

          {/* Admin Panel Trigger */}
          <button
            onClick={onOpenAdmin}
            id="nav-admin-btn"
            title="Open Admin Console"
            className="relative p-2 rounded-xl text-neutral-700 dark:text-neutral-300 bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 transition-colors border border-neutral-200 dark:border-neutral-700 cursor-pointer"
          >
            <ShieldCheck className="w-4 h-4 text-neutral-600 dark:text-neutral-300" />
            {unreadCount > 0 && (
              <span className="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-500 text-white text-[10px] font-bold flex items-center justify-center animate-pulse">
                {unreadCount}
              </span>
            )}
          </button>

          {/* Dark / Light Toggle */}
          <button
            onClick={() => setDarkMode(!darkMode)}
            id="theme-toggle-btn"
            aria-label="Toggle Theme"
            className="p-2 rounded-xl text-neutral-700 dark:text-neutral-300 bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 transition-colors border border-neutral-200 dark:border-neutral-700 cursor-pointer"
          >
            {darkMode ? <Sun className="w-4 h-4 text-amber-400" /> : <Moon className="w-4 h-4 text-neutral-700" />}
          </button>

          {/* Download CV CTA */}
          <button
            onClick={onOpenCv}
            id="nav-download-cv-btn"
            className="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 active:scale-95 shadow-sm shadow-rose-600/20 transition-all duration-200 cursor-pointer"
          >
            <FileDown className="w-3.5 h-3.5" />
            <span>CV</span>
          </button>
        </div>

        {/* Mobile Action buttons & Hamburger Toggle */}
        <div className="flex md:hidden items-center gap-2">
          <button
            onClick={() => setDarkMode(!darkMode)}
            className="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300"
            aria-label="Toggle Dark Mode"
          >
            {darkMode ? <Sun className="w-4 h-4 text-amber-400" /> : <Moon className="w-4 h-4 text-neutral-700" />}
          </button>

          <button
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            id="mobile-menu-toggle"
            className="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300"
            aria-label="Toggle Navigation Menu"
          >
            {mobileMenuOpen ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
          </button>
        </div>
      </div>

      {/* Mobile Drawer Menu */}
      {mobileMenuOpen && (
        <div
          id="mobile-drawer"
          className="md:hidden glass-panel border-b border-neutral-200 dark:border-neutral-800 px-5 pt-3 pb-6 space-y-3 mt-2 max-h-[80vh] overflow-y-auto"
        >
          {/* Mobile Auth Bar */}
          <div className="pb-3 border-b border-neutral-200 dark:border-neutral-800">
            {currentUser ? (
              <div className="flex items-center justify-between p-3 rounded-xl bg-rose-50/50 dark:bg-rose-950/30 border border-rose-200/60 dark:border-rose-900/40">
                <div className="flex items-center gap-2">
                  <User className="w-4 h-4 text-rose-600" />
                  <span className="text-xs font-bold text-neutral-900 dark:text-white">
                    {currentUser.fullName}
                  </span>
                </div>
                <div className="flex items-center gap-2">
                  <button
                    onClick={() => {
                      setMobileMenuOpen(false);
                      onOpenDashboard();
                    }}
                    className="px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-600 text-white"
                  >
                    Dashboard
                  </button>
                  <button
                    onClick={() => {
                      setMobileMenuOpen(false);
                      onLogout();
                    }}
                    className="p-1 text-neutral-500 hover:text-red-500"
                  >
                    <LogOut className="w-4 h-4" />
                  </button>
                </div>
              </div>
            ) : (
              <div className="grid grid-cols-2 gap-2">
                <button
                  onClick={() => {
                    setMobileMenuOpen(false);
                    onOpenLogin();
                  }}
                  className="flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-bold bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200"
                >
                  <LogIn className="w-3.5 h-3.5" />
                  <span>Login</span>
                </button>
                <button
                  onClick={() => {
                    setMobileMenuOpen(false);
                    onOpenRegister();
                  }}
                  className="flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-bold bg-rose-600 text-white shadow-xs"
                >
                  <UserPlus className="w-3.5 h-3.5" />
                  <span>Register</span>
                </button>
              </div>
            )}
          </div>

          <div className="flex flex-col space-y-1">
            {navLinks.map((link) => (
              <a
                key={link.name}
                href={link.href}
                onClick={() => setMobileMenuOpen(false)}
                className="px-3 py-2 rounded-lg text-sm font-medium text-neutral-700 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 flex items-center justify-between"
              >
                <span>{link.name}</span>
                <ArrowUpRight className="w-3.5 h-3.5 opacity-50" />
              </a>
            ))}
          </div>

          <div className="pt-3 border-t border-neutral-200 dark:border-neutral-800 flex flex-col gap-2">
            <button
              onClick={() => {
                setMobileMenuOpen(false);
                onOpenCv();
              }}
              className="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700"
            >
              <FileDown className="w-4 h-4" />
              <span>Download CV (PDF)</span>
            </button>

            <div className="grid grid-cols-2 gap-2">
              <button
                onClick={() => {
                  setMobileMenuOpen(false);
                  onOpenSourceModal();
                }}
                className="flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg text-xs font-medium bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200"
              >
                <FolderArchive className="w-3.5 h-3.5 text-amber-500" />
                <span>PHP Files</span>
              </button>
              <button
                onClick={() => {
                  setMobileMenuOpen(false);
                  onOpenAdmin();
                }}
                className="flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg text-xs font-medium bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200"
              >
                <ShieldCheck className="w-3.5 h-3.5 text-rose-500" />
                <span>Admin ({unreadCount})</span>
              </button>
            </div>
          </div>
        </div>
      )}
    </header>
  );
};
