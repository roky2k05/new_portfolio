import React, { useState } from 'react';
import { 
  GraduationCap, 
  Calendar, 
  MapPin, 
  CheckCircle2, 
  Sparkles, 
  ArrowRight,
  BookOpen,
  Award
} from 'lucide-react';
import { EDUCATION_DATA } from '../data/portfolioData';

export const EducationTimeline: React.FC = () => {
  const [selectedId, setSelectedId] = useState<string>('edu-3'); // ICBT default selected

  return (
    <section id="education" className="py-20 md:py-28 bg-neutral-50 dark:bg-[#0e1015] relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center max-w-2xl mx-auto mb-16">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold tracking-wider uppercase mb-3 border border-rose-200/60 dark:border-rose-900/40">
            <GraduationCap className="w-3.5 h-3.5" />
            <span>Academic Milestones</span>
          </div>
          <h2 className="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
            Education & Journey
          </h2>
          <div className="w-12 h-1 bg-rose-500 rounded-full mt-3 mb-4" />
          <p className="text-base text-neutral-600 dark:text-neutral-300">
            A chronological timeline of academic achievements, creative coursework, and current engineering studies.
          </p>
        </div>

        {/* Vertical Interactive Timeline */}
        <div className="relative max-w-4xl mx-auto">
          {/* Central Line */}
          <div className="absolute top-0 bottom-0 left-6 sm:left-1/2 w-0.5 -translate-x-1/2 bg-neutral-200 dark:bg-neutral-800" />

          <div className="space-y-12">
            {EDUCATION_DATA.map((item, index) => {
              const isEven = index % 2 === 0;
              const isSelected = selectedId === item.id;

              return (
                <div
                  key={item.id}
                  id={`timeline-item-${item.id}`}
                  className={`relative flex flex-col sm:flex-row items-start ${
                    isEven ? 'sm:flex-row-reverse' : ''
                  } group`}
                >
                  {/* Center Node Indicator */}
                  <div className="absolute left-6 sm:left-1/2 -translate-x-1/2 top-1.5 z-10 flex items-center justify-center">
                    <button
                      onClick={() => setSelectedId(item.id)}
                      className={`w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 cursor-pointer shadow-md ${
                        isSelected
                          ? 'bg-rose-600 text-white ring-4 ring-rose-500/20 scale-110'
                          : 'bg-white dark:bg-neutral-800 text-neutral-600 dark:text-neutral-300 border-2 border-neutral-300 dark:border-neutral-700 group-hover:border-rose-500'
                      }`}
                      aria-label={`Select ${item.title}`}
                    >
                      {item.status === 'Completed' ? (
                        <CheckCircle2 className="w-4 h-4" />
                      ) : item.status === 'Currently Studying' ? (
                        <BookOpen className="w-4 h-4" />
                      ) : (
                        <Sparkles className="w-4 h-4" />
                      )}
                    </button>
                  </div>

                  {/* Content Card */}
                  <div className="ml-14 sm:ml-0 sm:w-1/2 sm:px-8 w-full">
                    <div
                      onClick={() => setSelectedId(item.id)}
                      className={`p-6 rounded-2xl transition-all duration-200 cursor-pointer border ${
                        isSelected
                          ? 'bg-white dark:bg-neutral-900 border-rose-500/80 shadow-lg shadow-rose-500/5 ring-1 ring-rose-500/30'
                          : 'bg-white/70 dark:bg-neutral-900/60 border-neutral-200 dark:border-neutral-800 hover:border-neutral-300 dark:hover:border-neutral-700 shadow-xs'
                      }`}
                    >
                      {/* Top Meta: Year & Status */}
                      <div className="flex items-center justify-between gap-2 mb-2 flex-wrap">
                        <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold font-code bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200">
                          <Calendar className="w-3 h-3 text-rose-500" />
                          {item.year}
                        </span>

                        <span
                          className={`text-xs font-semibold px-2.5 py-0.5 rounded-full ${
                            item.status === 'Completed'
                              ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-900/40'
                              : item.status === 'Currently Studying'
                              ? 'bg-sky-50 dark:bg-sky-950/40 text-sky-600 dark:text-sky-400 border border-sky-200/60 dark:border-sky-900/40 animate-pulse'
                              : 'bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-400 border border-purple-200/60 dark:border-purple-900/40'
                          }`}
                        >
                          {item.status}
                        </span>
                      </div>

                      {/* Institution & Title */}
                      <h3 className="text-lg font-bold font-heading text-neutral-900 dark:text-white mt-1">
                        {item.title}
                      </h3>
                      <div className="text-sm font-semibold text-rose-600 dark:text-rose-400 mb-3">
                        {item.institution}
                      </div>

                      {/* Description */}
                      <p className="text-sm text-neutral-600 dark:text-neutral-300 leading-relaxed mb-4">
                        {item.description}
                      </p>

                      {/* Highlights */}
                      <div className="space-y-1.5 pt-3 border-t border-neutral-100 dark:border-neutral-800">
                        {item.highlights.map((h, i) => (
                          <div key={i} className="flex items-start gap-2 text-xs text-neutral-600 dark:text-neutral-400">
                            <ArrowRight className="w-3 h-3 text-rose-500 shrink-0 mt-0.5" />
                            <span>{h}</span>
                          </div>
                        ))}
                      </div>
                    </div>
                  </div>

                  {/* Empty side for desktop alignment */}
                  <div className="hidden sm:block sm:w-1/2" />
                </div>
              );
            })}
          </div>
        </div>

        {/* Bottom Note */}
        <div className="mt-16 text-center">
          <p className="text-xs text-neutral-500 dark:text-neutral-400 max-w-md mx-auto">
            * Formal education journey accurately reflects completed schooling at Rahula College, design certification at IMS Campus, and active Software Engineering studies at ICBT Campus.
          </p>
        </div>

      </div>
    </section>
  );
};
