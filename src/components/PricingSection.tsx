import React from 'react';
import { Check, Sparkles, MessageCircle, HelpCircle } from 'lucide-react';
import { PRICING_TIERS } from '../data/portfolioData';

interface PricingSectionProps {
  onOpenQuoteModal: (tierName?: string) => void;
}

export const PricingSection: React.FC<PricingSectionProps> = ({ onOpenQuoteModal }) => {
  return (
    <section id="pricing" className="py-20 md:py-28 bg-neutral-50 dark:bg-[#0e1015] border-b border-neutral-200/80 dark:border-neutral-800/80 relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="flex flex-col items-center text-center max-w-2xl mx-auto mb-16">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold tracking-wider uppercase mb-3 border border-rose-200/60 dark:border-rose-900/40">
            <Sparkles className="w-3.5 h-3.5" />
            <span>Investment Packages</span>
          </div>
          <h2 className="text-3xl sm:text-4xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight">
            Services & Custom Quotations
          </h2>
          <div className="w-12 h-1 bg-rose-500 rounded-full mt-3 mb-4" />
          <p className="text-base text-neutral-600 dark:text-neutral-300">
            Every project has distinct scopes and requirements. Receive a transparent, tailored quotation crafted specifically for your goals.
          </p>
        </div>

        {/* Pricing Cards Grid */}
        <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-12">
          {PRICING_TIERS.map((tier) => (
            <div
              key={tier.id}
              id={`pricing-card-${tier.id}`}
              className={`rounded-2xl p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 ${
                tier.isHighlighted
                  ? 'bg-neutral-900 text-white dark:bg-neutral-800/95 border-2 border-rose-500 shadow-xl relative'
                  : 'bg-white dark:bg-neutral-900/80 text-neutral-900 dark:text-white border border-neutral-200/90 dark:border-neutral-800 hover:border-neutral-300 shadow-xs'
              }`}
            >
              {tier.isHighlighted && (
                <div className="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-600 text-white shadow-xs">
                  Most Popular
                </div>
              )}

              <div>
                <h3 className="text-lg font-bold font-heading mb-2">
                  {tier.title}
                </h3>
                <p className={`text-xs mb-6 leading-relaxed ${tier.isHighlighted ? 'text-neutral-300' : 'text-neutral-500 dark:text-neutral-400'}`}>
                  {tier.idealFor}
                </p>

                <div className="py-4 border-y border-neutral-200/40 dark:border-neutral-700/60 mb-6">
                  <div className="text-xs font-semibold uppercase tracking-wider text-rose-500 mb-1">
                    Pricing
                  </div>
                  <div className="text-sm font-bold">
                    Custom Quotation
                  </div>
                  <div className={`text-[11px] mt-0.5 ${tier.isHighlighted ? 'text-neutral-400' : 'text-neutral-500'}`}>
                    Based on your requirements
                  </div>
                </div>

                {/* Features List */}
                <div className="space-y-2.5 mb-8">
                  {tier.features.map((feat, idx) => (
                    <div key={idx} className="flex items-start gap-2 text-xs leading-normal">
                      <Check className="w-3.5 h-3.5 text-emerald-400 shrink-0 mt-0.5" />
                      <span className={tier.isHighlighted ? 'text-neutral-200' : 'text-neutral-600 dark:text-neutral-300'}>
                        {feat}
                      </span>
                    </div>
                  ))}
                </div>
              </div>

              {/* Action Button */}
              <button
                onClick={() => onOpenQuoteModal(tier.title)}
                id={`quote-btn-${tier.id}`}
                className={`w-full py-2.5 px-4 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer ${
                  tier.isHighlighted
                    ? 'bg-rose-600 hover:bg-rose-700 text-white shadow-md'
                    : 'bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 text-neutral-800 dark:text-neutral-200'
                }`}
              >
                Get a Quote
              </button>
            </div>
          ))}
        </div>

        {/* Informational Banner */}
        <div className="p-6 rounded-2xl bg-rose-50/70 dark:bg-rose-950/20 border border-rose-200/70 dark:border-rose-900/40 flex flex-col sm:flex-row items-center justify-between gap-4">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
              <HelpCircle className="w-5 h-5" />
            </div>
            <div>
              <h4 className="text-sm font-bold text-neutral-900 dark:text-white">
                Need a tailored consultation for a complex project?
              </h4>
              <p className="text-xs text-neutral-600 dark:text-neutral-400">
                Contact Rasindu with your wireframes or project specs to receive a detailed breakdown and timeframe estimate.
              </p>
            </div>
          </div>
          <button
            onClick={() => onOpenQuoteModal('Custom Project')}
            className="shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 transition-colors cursor-pointer"
          >
            <MessageCircle className="w-3.5 h-3.5" />
            <span>Consult With Me</span>
          </button>
        </div>

      </div>
    </section>
  );
};
