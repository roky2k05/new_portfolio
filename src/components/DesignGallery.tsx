import React, { useState } from 'react';
import { 
  Palette, 
  ZoomIn, 
  X, 
  ChevronLeft, 
  ChevronRight, 
  PenTool, 
  Layers, 
  Maximize2,
  Sparkles
} from 'lucide-react';
import { DesignItem, DesignCategory } from '../types';
import { DESIGN_GALLERY_DATA } from '../data/portfolioData';

export const DesignGallery: React.FC = () => {
  const [activeCategory, setActiveCategory] = useState<DesignCategory>('All');
  const [lightboxIndex, setLightboxIndex] = useState<number | null>(null);

  const categories: DesignCategory[] = [
    'All',
    'Logo Design',
    'Poster',
    'Social Media',
    'Branding',
    'Typography',
    'Creative Artwork',
  ];

  const filteredItems = activeCategory === 'All'
    ? DESIGN_GALLERY_DATA
    : DESIGN_GALLERY_DATA.filter(item => item.category === activeCategory);

  const openLightbox = (index: number) => {
    setLightboxIndex(index);
  };

  const closeLightbox = () => {
    setLightboxIndex(null);
  };

  const nextLightbox = () => {
    if (lightboxIndex !== null) {
      setLightboxIndex((lightboxIndex + 1) % filteredItems.length);
    }
  };

  const prevLightbox = () => {
    if (lightboxIndex !== null) {
      setLightboxIndex((lightboxIndex - 1 + filteredItems.length) % filteredItems.length);
    }
  };

  const currentItem = lightboxIndex !== null ? filteredItems[lightboxIndex] : null;

  return (
    <section id="graphic-design" className="py-20 md:py-28 bg-white dark:bg-[#12141c] border-b border-neutral-200/80 dark:border-neutral-800/80 relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center max-w-2xl mx-auto mb-14">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold tracking-wider uppercase mb-3 border border-rose-200/60 dark:border-rose-900/40">
            <Palette className="w-3.5 h-3.5" />
            <span>Creative Design Studio</span>
          </div>
          <h2 className="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
            Graphic Design Showcase
          </h2>
          <div className="w-12 h-1 bg-rose-500 rounded-full mt-3 mb-4" />
          <p className="text-base text-neutral-600 dark:text-neutral-300">
            Vector logos, brand identity marks, event posters, and typography creations crafted in Adobe Illustrator and Photoshop.
          </p>
        </div>

        {/* Categories Filter Pills */}
        <div className="flex justify-center flex-wrap gap-2 mb-12">
          {categories.map((cat) => (
            <button
              key={cat}
              onClick={() => setActiveCategory(cat)}
              id={`gallery-filter-${cat.toLowerCase().replace(/\s+/g, '-')}`}
              className={`px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer ${
                activeCategory === cat
                  ? 'bg-rose-600 text-white shadow-sm scale-105'
                  : 'bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white border border-neutral-200 dark:border-neutral-800'
              }`}
            >
              {cat}
            </button>
          ))}
        </div>

        {/* Masonry / Responsive Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredItems.map((item, idx) => (
            <div
              key={item.id}
              onClick={() => openLightbox(idx)}
              id={`gallery-item-${item.id}`}
              className="group relative rounded-2xl overflow-hidden bg-neutral-100 dark:bg-neutral-800 border border-neutral-200/80 dark:border-neutral-800 shadow-xs cursor-pointer hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
            >
              {/* Image with Aspect Ratio Handling */}
              <div className="relative aspect-[4/3] overflow-hidden">
                <img
                  src={item.image}
                  alt={item.title}
                  loading="lazy"
                  className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                />

                {/* Top Category Badge */}
                <div className="absolute top-3 left-3 z-10">
                  <span className="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-neutral-900/80 text-white backdrop-blur-md border border-neutral-700/50">
                    {item.category}
                  </span>
                </div>

                {/* Hover Reveal Details Overlay */}
                <div className="absolute inset-0 bg-gradient-to-t from-neutral-950/90 via-neutral-950/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5 text-white">
                  <div className="flex items-center justify-between mb-1.5">
                    <h3 className="text-base font-bold font-heading">
                      {item.title}
                    </h3>
                    <ZoomIn className="w-4 h-4 text-rose-400" />
                  </div>
                  <p className="text-xs text-neutral-300 line-clamp-2 mb-3">
                    {item.description}
                  </p>
                  <div className="flex flex-wrap gap-1.5">
                    {item.tools.map((t, i) => (
                      <span key={i} className="px-2 py-0.5 rounded-md text-[10px] font-code bg-white/20 text-white">
                        {t}
                      </span>
                    ))}
                  </div>
                </div>
              </div>

              {/* Bottom Visible Info on mobile / default */}
              <div className="p-4 bg-white dark:bg-neutral-900/90 flex items-center justify-between">
                <div>
                  <h4 className="text-sm font-bold text-neutral-900 dark:text-white">
                    {item.title}
                  </h4>
                  <div className="text-xs text-neutral-500 dark:text-neutral-400">
                    {item.tools.join(' • ')}
                  </div>
                </div>
                <button
                  className="p-2 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-300 group-hover:text-rose-500 transition-colors"
                  aria-label="View Fullscreen"
                >
                  <Maximize2 className="w-3.5 h-3.5" />
                </button>
              </div>
            </div>
          ))}
        </div>

      </div>

      {/* Lightbox Modal */}
      {currentItem && lightboxIndex !== null && (
        <div
          className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-950/90 backdrop-blur-md"
          role="dialog"
          aria-modal="true"
        >
          {/* Close Lightbox */}
          <button
            onClick={closeLightbox}
            className="absolute top-5 right-5 z-20 p-2.5 rounded-full bg-neutral-900/80 text-white hover:bg-neutral-800 transition-colors cursor-pointer"
            aria-label="Close Lightbox"
          >
            <X className="w-6 h-6" />
          </button>

          {/* Previous Button */}
          <button
            onClick={prevLightbox}
            className="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-neutral-900/80 text-white hover:bg-rose-600 transition-colors cursor-pointer"
            aria-label="Previous image"
          >
            <ChevronLeft className="w-6 h-6" />
          </button>

          {/* Next Button */}
          <button
            onClick={nextLightbox}
            className="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-neutral-900/80 text-white hover:bg-rose-600 transition-colors cursor-pointer"
            aria-label="Next image"
          >
            <ChevronRight className="w-6 h-6" />
          </button>

          {/* Lightbox Content */}
          <div className="max-w-4xl w-full max-h-[90vh] flex flex-col items-center justify-center">
            <div className="relative max-h-[70vh] overflow-hidden rounded-xl shadow-2xl mb-4">
              <img
                src={currentItem.image}
                alt={currentItem.title}
                className="max-h-[70vh] w-auto object-contain rounded-xl"
              />
            </div>

            <div className="bg-neutral-900/90 text-white p-4 sm:p-6 rounded-2xl max-w-2xl w-full border border-neutral-800 text-center">
              <div className="flex items-center justify-center gap-2 mb-1.5">
                <span className="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-600 text-white">
                  {currentItem.category}
                </span>
                <span className="text-xs text-neutral-400">
                  {lightboxIndex + 1} of {filteredItems.length}
                </span>
              </div>
              <h3 className="text-xl font-bold font-heading mb-1.5">
                {currentItem.title}
              </h3>
              <p className="text-xs sm:text-sm text-neutral-300 mb-3">
                {currentItem.description}
              </p>
              <div className="flex justify-center items-center gap-2 text-xs text-neutral-400">
                <PenTool className="w-3.5 h-3.5 text-rose-400" />
                <span>Tools: {currentItem.tools.join(', ')}</span>
              </div>
            </div>
          </div>
        </div>
      )}
    </section>
  );
};
