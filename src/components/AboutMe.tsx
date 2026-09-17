import React, { useState } from 'react';
import { 
  MapPin, 
  GraduationCap, 
  Sparkles, 
  Clock, 
  ChevronRight, 
  Code, 
  Palette, 
  CheckCircle2, 
  X,
  UserCheck,
  Compass
} from 'lucide-react';
import { PERSONAL_INFO } from '../data/portfolioData';

export const AboutMe: React.FC = () => {
  const [readMoreOpen, setReadMoreOpen] = useState(false);

  const infoCards = [
    {
      icon: MapPin,
      label: 'Location',
      value: 'Matara, Akuressa',
      sub: 'Sri Lanka (Citizen)',
      color: 'text-rose-500',
      bg: 'bg-rose-500/10',
    },
    {
      icon: GraduationCap,
      label: 'Education',
      value: 'ICBT Campus',
      sub: 'CSE Diploma Student',
      color: 'text-sky-500',
      bg: 'bg-sky-500/10',
    },
    {
      icon: Palette,
      label: 'Focus',
      value: 'Web & Graphic Design',
      sub: 'Code + Visual Art',
      color: 'text-amber-500',
      bg: 'bg-amber-500/10',
    },
    {
      icon: Clock,
      label: 'Status',
      value: 'Currently Studying',
      sub: 'Available for Projects',
      color: 'text-emerald-500',
      bg: 'bg-emerald-500/10',
    },
  ];

  return (
    <section id="about" className="py-20 md:py-28 bg-white dark:bg-[#12141c] border-y border-neutral-200/80 dark:border-neutral-800/80 relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center max-w-2xl mx-auto mb-16">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold tracking-wider uppercase mb-3 border border-rose-200/60 dark:border-rose-900/40">
            <Compass className="w-3.5 h-3.5" />
            <span>Discover My Background</span>
          </div>
          <h2 className="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
            About Me
          </h2>
          <div className="w-12 h-1 bg-rose-500 rounded-full mt-3 mb-4" />
          <p className="text-base text-neutral-600 dark:text-neutral-300">
            Blending computational logic with visual artistry to craft memorable web experiences.
          </p>
        </div>

        {/* Main Content Grid */}
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
          
          {/* Left Column: Bio Story */}
          <div className="lg:col-span-7 space-y-6 text-neutral-700 dark:text-neutral-300 leading-relaxed text-base">
            <p className="text-lg font-medium text-neutral-900 dark:text-neutral-100 leading-relaxed">
              Hello! I'm <strong className="text-rose-600 dark:text-rose-400 font-bold">{PERSONAL_INFO.name}</strong>, a Sri Lankan citizen based in Akuressa, Matara. I am dedicated to modern web engineering and creative visual design.
            </p>

            <p>
              My path in technology was rooted during my school education at <strong>Rahula College</strong>, where I developed a strong appreciation for discipline, structured problem solving, and analytical thinking. In 2024, upon completing my schooling, I actively pursued formal creative training by completing the Graphic Design program at <strong>IMS Campus</strong>.
            </p>

            <p>
              Currently, I am advancing my software engineering foundations at <strong>ICBT Campus</strong>, pursuing a Diploma in Computer and Software Engineering. Here, I bridge theoretical computing concepts with practical full-stack projects using PHP, MySQL, JavaScript, HTML5/CSS3, and Java.
            </p>

            <div className="p-4 rounded-xl bg-neutral-50 dark:bg-neutral-900/60 border border-neutral-200 dark:border-neutral-800 flex items-start gap-3.5">
              <Sparkles className="w-5 h-5 text-amber-500 shrink-0 mt-0.5" />
              <p className="text-sm text-neutral-700 dark:text-neutral-300 leading-normal">
                <span className="font-semibold text-neutral-900 dark:text-white">The Dual Advantage:</span> Because I work as both a Web Developer and a Graphic Designer, I eliminate the typical gap between design mockups and actual code. Every layout I conceive is both visually striking and mathematically feasible.
              </p>
            </div>

            {/* Read More Trigger */}
            <div>
              <button
                onClick={() => setReadMoreOpen(true)}
                id="about-read-more-btn"
                className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-neutral-900 dark:text-white bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 transition-colors cursor-pointer"
              >
                <span>Read Full Story & Philosophy</span>
                <ChevronRight className="w-4 h-4 text-rose-500" />
              </button>
            </div>
          </div>

          {/* Right Column: 4 Small Info Cards & Highlights */}
          <div className="lg:col-span-5 space-y-6">
            
            {/* 4 Cards Grid */}
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              {infoCards.map((card, idx) => {
                const IconComponent = card.icon;
                return (
                  <div
                    key={idx}
                    id={`about-card-${card.label.toLowerCase().replace(/\s+/g, '-')}`}
                    className="p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900/80 border border-neutral-200/90 dark:border-neutral-800 hover:border-neutral-300 dark:hover:border-neutral-700 transition-all duration-200 shadow-xs"
                  >
                    <div className={`w-10 h-10 rounded-xl ${card.bg} ${card.color} flex items-center justify-center mb-3`}>
                      <IconComponent className="w-5 h-5" />
                    </div>
                    <div className="text-xs text-neutral-500 dark:text-neutral-400 font-medium uppercase tracking-wider mb-1">
                      {card.label}
                    </div>
                    <div className="text-base font-bold font-heading text-neutral-900 dark:text-white">
                      {card.value}
                    </div>
                    <div className="text-xs text-neutral-600 dark:text-neutral-400 mt-0.5">
                      {card.sub}
                    </div>
                  </div>
                );
              })}
            </div>

            {/* Pillars of Work */}
            <div className="p-6 rounded-2xl bg-neutral-900 text-white dark:bg-neutral-800/80 border border-neutral-800 dark:border-neutral-700 shadow-lg space-y-3">
              <div className="text-xs font-semibold uppercase tracking-wider text-rose-400">
                Core Principles
              </div>
              <div className="space-y-2 text-sm text-neutral-300">
                <div className="flex items-center gap-2.5">
                  <CheckCircle2 className="w-4 h-4 text-emerald-400 shrink-0" />
                  <span>Clean, semantic code adhering to web standards</span>
                </div>
                <div className="flex items-center gap-2.5">
                  <CheckCircle2 className="w-4 h-4 text-emerald-400 shrink-0" />
                  <span>Pixel-precise graphic vector design & typography</span>
                </div>
                <div className="flex items-center gap-2.5">
                  <CheckCircle2 className="w-4 h-4 text-emerald-400 shrink-0" />
                  <span>Mobile-first responsive execution from 320px to 4K</span>
                </div>
                <div className="flex items-center gap-2.5">
                  <CheckCircle2 className="w-4 h-4 text-emerald-400 shrink-0" />
                  <span>Secure PHP 8+ database handling using PDO prepared statements</span>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>

      {/* Read More Modal */}
      {readMoreOpen && (
        <div 
          className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-950/70 backdrop-blur-sm"
          role="dialog"
          aria-modal="true"
        >
          <div className="bg-white dark:bg-[#151722] rounded-2xl max-w-2xl w-full max-h-[85vh] overflow-y-auto p-6 sm:p-8 border border-neutral-200 dark:border-neutral-800 shadow-2xl relative">
            
            <button
              onClick={() => setReadMoreOpen(false)}
              className="absolute top-5 right-5 p-2 rounded-xl text-neutral-500 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-white bg-neutral-100 dark:bg-neutral-800 cursor-pointer"
              aria-label="Close modal"
            >
              <X className="w-5 h-5" />
            </button>

            <div className="flex items-center gap-2.5 text-xs font-semibold text-rose-600 dark:text-rose-400 uppercase tracking-wider mb-2">
              <UserCheck className="w-4 h-4" />
              <span>Full Biography & Philosophy</span>
            </div>

            <h3 className="text-2xl font-bold font-heading text-neutral-900 dark:text-white mb-6">
              The Journey of Rasindu Nawod
            </h3>

            <div className="space-y-4 text-sm sm:text-base text-neutral-600 dark:text-neutral-300 leading-relaxed">
              <p>
                Growing up in Matara and Akuressa, Sri Lanka, I always held a fascination with how visual art and technology intertwine. When computers and internet connectivity became my everyday tools, I wasn't just interested in using applications—I wanted to understand how they are built and how to design them with elegance.
              </p>

              <h4 className="text-lg font-bold text-neutral-900 dark:text-white pt-2">
                1. Educational Rigor at Rahula College (2024)
              </h4>
              <p>
                Rahula College provided the foundation of discipline, team spirit, and mathematical aptitude. Finishing my formal secondary education in 2024 gave me the confidence to dive directly into technical disciplines.
              </p>

              <h4 className="text-lg font-bold text-neutral-900 dark:text-white pt-2">
                2. Visual Precision at IMS Campus
              </h4>
              <p>
                At IMS Campus, I pursued my passion for graphic design. Here I gained mastery over Adobe Illustrator and Adobe Photoshop, studying color theory, vector manipulation, corporate brand identity, and typography. This training taught me that design is not decoration; it is communication.
              </p>

              <h4 className="text-lg font-bold text-neutral-900 dark:text-white pt-2">
                3. Software Engineering at ICBT Campus
              </h4>
              <p>
                Recognizing that great designs require high-performance code to come to life, I enrolled in the Diploma in Computer and Software Engineering at ICBT Campus. Through rigorous coursework in PHP, MySQL, JavaScript, Java, and software development lifecycles, I am developing the technical depth needed for full-stack web solutions.
              </p>

              <h4 className="text-lg font-bold text-neutral-900 dark:text-white pt-2">
                4. Continuous Learning & Future Vision
              </h4>
              <p>
                The digital landscape evolves daily. I continuously update my skill set with modern frameworks, Tailwind CSS, API architectures, and design trends. My vision is to deliver polished digital solutions for businesses, universities, and creative ventures worldwide.
              </p>
            </div>

            <div className="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-800 flex justify-end">
              <button
                onClick={() => setReadMoreOpen(false)}
                className="px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 cursor-pointer"
              >
                Close Biography
              </button>
            </div>

          </div>
        </div>
      )}
    </section>
  );
};
