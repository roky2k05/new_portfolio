import React from 'react';
import { 
  FileDown, 
  ArrowDown, 
  MessageSquare, 
  Sparkles, 
  Code2, 
  PenTool, 
  Layers, 
  CheckCircle2, 
  MapPin, 
  Terminal,
  ExternalLink
} from 'lucide-react';
import { PERSONAL_INFO } from '../data/portfolioData';

interface HeroProps {
  onOpenCv: () => void;
  onOpenQuoteModal: () => void;
}

export const Hero: React.FC<HeroProps> = ({ onOpenCv, onOpenQuoteModal }) => {
  return (
    <section
      id="home"
      className="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden"
    >
      {/* Subtle Background Grid & Gradients */}
      <div className="absolute inset-0 pointer-events-none -z-10">
        <div className="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-rose-500/8 dark:bg-rose-500/12 rounded-full blur-3xl" />
        <div className="absolute top-1/3 right-10 w-[300px] h-[300px] bg-amber-500/5 dark:bg-amber-500/8 rounded-full blur-2xl" />
        <div 
          className="absolute inset-0 opacity-[0.03] dark:opacity-[0.06]"
          style={{
            backgroundImage: `radial-gradient(currentColor 1px, transparent 1px)`,
            backgroundSize: '24px 24px'
          }}
        />
      </div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
          
          {/* Left Column: Headlines, Description & CTAs */}
          <div className="lg:col-span-7 flex flex-col items-start text-left">
            
            {/* Availability & Location Pill */}
            <div className="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-neutral-100 dark:bg-neutral-800/90 border border-neutral-200/90 dark:border-neutral-700/80 mb-6 shadow-xs">
              <span className="relative flex h-2 w-2">
                <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span className="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
              </span>
              <span className="text-xs font-semibold text-neutral-800 dark:text-neutral-200">
                Available for Projects
              </span>
              <span className="text-neutral-300 dark:text-neutral-600">•</span>
              <span className="text-xs text-neutral-600 dark:text-neutral-400 flex items-center gap-1">
                <MapPin className="w-3 h-3 text-rose-500" />
                Matara, Sri Lanka
              </span>
            </div>

            {/* Name & Title Subhead */}
            <div className="space-y-1.5 mb-3">
              <div className="inline-flex items-center gap-2">
                <span className="text-sm font-semibold tracking-wider uppercase text-rose-600 dark:text-rose-400">
                  {PERSONAL_INFO.title}
                </span>
                <span className="h-px w-8 bg-rose-500/40" />
              </div>
              <h2 className="text-2xl sm:text-3xl font-bold font-heading text-neutral-900 dark:text-white tracking-tight">
                {PERSONAL_INFO.name}
              </h2>
            </div>

            {/* Main Headline */}
            <h1 className="text-4xl sm:text-5xl lg:text-6xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight leading-[1.12] mb-6">
              Turning Ideas Into{' '}
              <span className="relative inline-block text-neutral-900 dark:text-white">
                <span className="relative z-10 text-rose-600 dark:text-rose-500">Digital Experiences.</span>
                <span className="absolute bottom-1 left-0 right-0 h-2.5 bg-rose-500/15 dark:bg-rose-500/20 -rotate-1 rounded-sm -z-0" />
              </span>
            </h1>

            {/* Supporting Text */}
            <p className="text-base sm:text-lg text-neutral-600 dark:text-neutral-300 leading-relaxed max-w-2xl mb-8">
              {PERSONAL_INFO.supportingText}
            </p>

            {/* Action Buttons */}
            <div className="flex flex-wrap items-center gap-3.5 w-full sm:w-auto mb-10">
              <a
                href="#projects"
                id="hero-view-work-btn"
                className="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-semibold text-sm text-white bg-neutral-900 hover:bg-neutral-800 dark:bg-white dark:text-neutral-900 dark:hover:bg-neutral-100 shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer active:scale-95"
              >
                <span>View My Work</span>
                <ArrowDown className="w-4 h-4" />
              </a>

              <button
                onClick={onOpenCv}
                id="hero-download-cv-btn"
                className="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-semibold text-sm text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-950/70 border border-rose-200 dark:border-rose-900/60 shadow-xs transition-all duration-200 cursor-pointer active:scale-95"
              >
                <FileDown className="w-4 h-4" />
                <span>Download CV</span>
              </button>

              <a
                href="#contact"
                id="hero-lets-talk-btn"
                className="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl font-semibold text-sm text-neutral-700 dark:text-neutral-200 bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 transition-all duration-200 cursor-pointer active:scale-95"
              >
                <MessageSquare className="w-4 h-4 text-neutral-500" />
                <span>Let's Talk</span>
              </a>
            </div>

            {/* Quick Metrics Bar */}
            <div className="grid grid-cols-3 gap-6 pt-6 border-t border-neutral-200 dark:border-neutral-800 w-full max-w-lg">
              <div>
                <div className="font-heading font-extrabold text-2xl text-neutral-900 dark:text-white">
                  2024
                </div>
                <div className="text-xs text-neutral-500 dark:text-neutral-400 font-medium">
                  Rahula College
                </div>
              </div>

              <div>
                <div className="font-heading font-extrabold text-2xl text-rose-600 dark:text-rose-500">
                  IMS
                </div>
                <div className="text-xs text-neutral-500 dark:text-neutral-400 font-medium">
                  Graphic Design
                </div>
              </div>

              <div>
                <div className="font-heading font-extrabold text-2xl text-neutral-900 dark:text-white">
                  ICBT
                </div>
                <div className="text-xs text-neutral-500 dark:text-neutral-400 font-medium">
                  CSE Diploma (Studying)
                </div>
              </div>
            </div>

          </div>

          {/* Right Column: Creative Visual Composition (Code Mockup + Design Tools + Profile) */}
          <div className="lg:col-span-5 relative flex items-center justify-center">
            
            {/* Visual Container Card */}
            <div className="relative w-full max-w-md mx-auto">
              
              {/* Back Card: Subtle Code Editor Window */}
              <div className="rounded-2xl bg-neutral-900 text-neutral-200 p-5 shadow-2xl border border-neutral-800 relative z-10 overflow-hidden">
                {/* Window Header */}
                <div className="flex items-center justify-between pb-3.5 mb-3.5 border-b border-neutral-800">
                  <div className="flex items-center gap-1.5">
                    <div className="w-3 h-3 rounded-full bg-rose-500/90" />
                    <div className="w-3 h-3 rounded-full bg-amber-500/90" />
                    <div className="w-3 h-3 rounded-full bg-emerald-500/90" />
                  </div>
                  <div className="flex items-center gap-1.5 text-xs text-neutral-400 font-code font-medium">
                    <Terminal className="w-3.5 h-3.5 text-rose-400" />
                    <span>rasindu-profile.js</span>
                  </div>
                  <div className="w-12 text-right text-[10px] text-neutral-500">PHP 8+</div>
                </div>

                {/* Code Snippet */}
                <pre className="text-xs font-code leading-relaxed text-neutral-300 overflow-x-auto selection:bg-rose-600/30">
                  <code>
                    <span className="text-rose-400">const</span>{' '}
                    <span className="text-amber-300">rasindu</span> = &#123;{'\n'}
                    {'  '}name: <span className="text-emerald-400">"Rasindu Nawod"</span>,{'\n'}
                    {'  '}roles: [<span className="text-emerald-400">"Web Dev"</span>, <span className="text-emerald-400">"Graphic Designer"</span>],{'\n'}
                    {'  '}location: <span className="text-emerald-400">"Matara, Sri Lanka"</span>,{'\n'}
                    {'  '}education: <span className="text-emerald-400">"ICBT Campus (CSE)"</span>,{'\n'}
                    {'  '}tools: [<span className="text-sky-300">"HTML"</span>, <span className="text-sky-300">"PHP"</span>, <span className="text-sky-300">"Illustrator"</span>],{'\n'}
                    {'  '}passion: <span className="text-rose-400">function</span>() &#123;{'\n'}
                    {'    '}return <span className="text-emerald-400">"Turning Ideas Into Reality"</span>;{'\n'}
                    {'  '}&#125;{'\n'}
                    &#125;;
                  </code>
                </pre>

                {/* Quick Execution Status */}
                <div className="mt-4 pt-3 border-t border-neutral-800 flex items-center justify-between text-[11px] text-neutral-400">
                  <span className="flex items-center gap-1.5 text-emerald-400 font-medium">
                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse" />
                    Status: Compiling & Ready
                  </span>
                  <span className="font-code text-neutral-500">v2.4.0</span>
                </div>
              </div>

              {/* Floating Element 1: Graphic Design Palette & Pen Tool Card */}
              <div className="absolute -bottom-6 -left-4 sm:-left-8 z-20 bg-white dark:bg-neutral-800 p-3.5 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-xl flex items-center gap-3 backdrop-blur-md">
                <div className="w-10 h-10 rounded-lg bg-rose-500/10 dark:bg-rose-500/20 text-rose-600 dark:text-rose-400 flex items-center justify-center">
                  <PenTool className="w-5 h-5" />
                </div>
                <div>
                  <div className="text-xs font-bold text-neutral-900 dark:text-white flex items-center gap-1">
                    <span>Adobe Creative Cloud</span>
                    <Sparkles className="w-3 h-3 text-amber-500" />
                  </div>
                  <div className="text-[11px] text-neutral-500 dark:text-neutral-400">
                    Illustrator & Photoshop
                  </div>
                  {/* Swatches */}
                  <div className="flex items-center gap-1 mt-1">
                    <span className="w-3 h-3 rounded-full bg-rose-600" title="Primary Red" />
                    <span className="w-3 h-3 rounded-full bg-neutral-900 dark:bg-white" title="High Contrast" />
                    <span className="w-3 h-3 rounded-full bg-amber-500" title="Warm Accent" />
                    <span className="w-3 h-3 rounded-full bg-sky-500" title="Tech Blue" />
                  </div>
                </div>
              </div>

              {/* Floating Element 2: Web Dev Badge */}
              <div className="absolute -top-6 -right-4 sm:-right-6 z-20 bg-white dark:bg-neutral-800 py-2.5 px-3.5 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-xl flex items-center gap-2.5 backdrop-blur-md">
                <div className="w-8 h-8 rounded-lg bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                  <Code2 className="w-4 h-4" />
                </div>
                <div>
                  <div className="text-xs font-bold text-neutral-900 dark:text-white">
                    Full-Stack & Responsive
                  </div>
                  <div className="text-[10px] text-neutral-500 dark:text-neutral-400">
                    HTML • CSS • JS • PHP • MySQL
                  </div>
                </div>
              </div>

              {/* Floating Element 3: Sri Lankan Pride Badge */}
              <div className="absolute top-1/2 -right-8 -translate-y-1/2 hidden sm:flex items-center gap-2 bg-neutral-900/90 text-white text-[11px] font-medium px-3 py-1.5 rounded-full shadow-lg border border-neutral-700 z-30">
                <span className="text-sm">🇱🇰</span>
                <span>Matara, Sri Lanka</span>
              </div>

            </div>

          </div>

        </div>
      </div>
    </section>
  );
};
