import React, { useState } from 'react';
import { 
  Quote, 
  ChevronLeft, 
  ChevronRight, 
  Star, 
  ShieldAlert,
  MessageSquareHeart
} from 'lucide-react';
import { TESTIMONIALS_DATA } from '../data/portfolioData';

export const TestimonialsSlider: React.FC = () => {
  const [currentIndex, setCurrentIndex] = useState(0);

  const prevSlide = () => {
    setCurrentIndex((prev) => (prev === 0 ? TESTIMONIALS_DATA.length - 1 : prev - 1));
  };

  const nextSlide = () => {
    setCurrentIndex((prev) => (prev === TESTIMONIALS_DATA.length - 1 ? 0 : prev + 1));
  };

  const current = TESTIMONIALS_DATA[currentIndex];

  return (
    <section id="testimonials" className="py-20 md:py-28 bg-white dark:bg-[#12141c] border-b border-neutral-200/80 dark:border-neutral-800/80 relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center max-w-2xl mx-auto mb-16">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold tracking-wider uppercase mb-3 border border-rose-200/60 dark:border-rose-900/40">
            <MessageSquareHeart className="w-3.5 h-3.5" />
            <span>Community & Feedback</span>
          </div>
          <h2 className="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
            Academic & Peer Feedback
          </h2>
          <div className="w-12 h-1 bg-rose-500 rounded-full mt-3 mb-4" />
          <p className="text-base text-neutral-600 dark:text-neutral-300">
            Perspectives from mentors and collaborators. Sample demonstrations clearly labeled per authenticity guidelines.
          </p>
        </div>

        {/* Testimonials Card Slider */}
        <div className="max-w-3xl mx-auto relative">
          
          {/* Main Card */}
          <div className="p-8 sm:p-12 rounded-3xl bg-neutral-50 dark:bg-neutral-900/80 border border-neutral-200/90 dark:border-neutral-800 shadow-xl relative overflow-hidden transition-all duration-300">
            
            {/* Watermark Quote Icon */}
            <Quote className="absolute top-6 right-8 w-20 h-20 text-neutral-200/60 dark:text-neutral-800/50 pointer-events-none" />

            {/* Sample Badge */}
            {current.isSample && (
              <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-semibold bg-amber-100 dark:bg-amber-950/50 text-amber-700 dark:text-amber-400 mb-6 border border-amber-300 dark:border-amber-800">
                <ShieldAlert className="w-3 h-3" />
                <span>Sample Content • Placeholder for Client Reviews</span>
              </div>
            )}

            {/* Stars */}
            <div className="flex items-center gap-1 mb-6 text-amber-400">
              {[...Array(5)].map((_, i) => (
                <Star key={i} className="w-4 h-4 fill-current" />
              ))}
            </div>

            {/* Quote Content */}
            <p className="text-base sm:text-lg text-neutral-700 dark:text-neutral-200 leading-relaxed italic mb-8 relative z-10">
              "{current.content}"
            </p>

            {/* Author Profile */}
            <div className="flex items-center justify-between gap-4 pt-6 border-t border-neutral-200/80 dark:border-neutral-800">
              <div className="flex items-center gap-4">
                <img
                  src={current.avatar}
                  alt={current.name}
                  className="w-12 h-12 rounded-full object-cover border-2 border-rose-500/50"
                />
                <div>
                  <h4 className="text-base font-bold font-heading text-neutral-900 dark:text-white">
                    {current.name}
                  </h4>
                  <p className="text-xs text-rose-600 dark:text-rose-400 font-semibold">
                    {current.role}
                  </p>
                  <p className="text-xs text-neutral-500 dark:text-neutral-400">
                    {current.organization}
                  </p>
                </div>
              </div>

              {/* Slider Arrows */}
              <div className="flex items-center gap-2">
                <button
                  onClick={prevSlide}
                  id="testimonial-prev-btn"
                  className="p-2.5 rounded-full bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300 hover:text-rose-600 hover:border-rose-500 transition-colors cursor-pointer"
                  aria-label="Previous Testimonial"
                >
                  <ChevronLeft className="w-4 h-4" />
                </button>
                <button
                  onClick={nextSlide}
                  id="testimonial-next-btn"
                  className="p-2.5 rounded-full bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300 hover:text-rose-600 hover:border-rose-500 transition-colors cursor-pointer"
                  aria-label="Next Testimonial"
                >
                  <ChevronRight className="w-4 h-4" />
                </button>
              </div>
            </div>

          </div>

          {/* Dots Indicator */}
          <div className="flex items-center justify-center gap-2 mt-6">
            {TESTIMONIALS_DATA.map((_, idx) => (
              <button
                key={idx}
                onClick={() => setCurrentIndex(idx)}
                className={`h-2 rounded-full transition-all duration-300 cursor-pointer ${
                  currentIndex === idx ? 'w-8 bg-rose-600' : 'w-2 bg-neutral-300 dark:bg-neutral-700'
                }`}
                aria-label={`Go to slide ${idx + 1}`}
              />
            ))}
          </div>

        </div>

      </div>
    </section>
  );
};
