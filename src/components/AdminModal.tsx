import React, { useState } from 'react';
import { 
  ShieldCheck, 
  X, 
  Mail, 
  Phone, 
  Clock, 
  CheckCircle, 
  Inbox, 
  MessageSquare, 
  Trash2, 
  ExternalLink,
  Download,
  Search,
  Filter,
  Layers,
  Database
} from 'lucide-react';
import { ContactMessage } from '../types';

interface AdminModalProps {
  isOpen: boolean;
  onClose: () => void;
  messages: ContactMessage[];
  onUpdateStatus: (id: string, newStatus: 'Unread' | 'Read' | 'Replied') => void;
  onDeleteMessage: (id: string) => void;
}

export const AdminModal: React.FC<AdminModalProps> = ({
  isOpen,
  onClose,
  messages,
  onUpdateStatus,
  onDeleteMessage,
}) => {
  if (!isOpen) return null;

  const [activeTab, setActiveTab] = useState<'messages' | 'database' | 'overview'>('messages');
  const [filterStatus, setFilterStatus] = useState<string>('All');
  const [selectedMessage, setSelectedMessage] = useState<ContactMessage | null>(
    messages.length > 0 ? messages[0] : null
  );

  const filteredMessages = messages.filter((m) => {
    if (filterStatus === 'All') return true;
    return m.status === filterStatus;
  });

  const unreadCount = messages.filter((m) => m.status === 'Unread').length;
  const readCount = messages.filter((m) => m.status === 'Read').length;
  const repliedCount = messages.filter((m) => m.status === 'Replied').length;

  const handleExportJSON = () => {
    const dataStr = 'data:text/json;charset=utf-8,' + encodeURIComponent(JSON.stringify(messages, null, 2));
    const downloadAnchor = document.createElement('a');
    downloadAnchor.setAttribute('href', dataStr);
    downloadAnchor.setAttribute('download', 'contact_messages_backup.json');
    document.body.appendChild(downloadAnchor);
    downloadAnchor.click();
    downloadAnchor.remove();
  };

  return (
    <div
      className="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6 bg-neutral-950/85 backdrop-blur-md animate-fade-in"
      role="dialog"
      aria-modal="true"
    >
      <div className="bg-white dark:bg-[#12141c] rounded-3xl max-w-5xl w-full h-[90vh] flex flex-col border border-neutral-200 dark:border-neutral-800 shadow-2xl overflow-hidden relative">
        
        {/* Top Header Bar */}
        <div className="p-4 sm:p-5 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between bg-neutral-50 dark:bg-neutral-900/80">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center shadow-md">
              <ShieldCheck className="w-5 h-5" />
            </div>
            <div>
              <div className="flex items-center gap-2">
                <h2 className="text-base font-bold font-heading text-neutral-900 dark:text-white">
                  Rasindu Nawod • Portfolio Administration
                </h2>
                <span className="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
                  Live Session
                </span>
              </div>
              <p className="text-xs text-neutral-500 dark:text-neutral-400">
                Manage contact inquiries, preview database schemas & sync status
              </p>
            </div>
          </div>

          <div className="flex items-center gap-2">
            <button
              onClick={handleExportJSON}
              className="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 transition-colors cursor-pointer"
              title="Export all messages as JSON"
            >
              <Download className="w-3.5 h-3.5" />
              <span>Export JSON</span>
            </button>

            <button
              onClick={onClose}
              className="p-2 rounded-xl text-neutral-500 hover:text-neutral-900 dark:hover:text-white bg-neutral-200/60 dark:bg-neutral-800 cursor-pointer"
              aria-label="Close Admin Modal"
            >
              <X className="w-5 h-5" />
            </button>
          </div>
        </div>

        {/* Sub Navigation Bar */}
        <div className="px-4 sm:px-6 py-2.5 border-b border-neutral-200 dark:border-neutral-800 bg-white dark:bg-[#151722] flex items-center justify-between gap-4 overflow-x-auto">
          <div className="flex items-center gap-2">
            <button
              onClick={() => setActiveTab('messages')}
              className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer flex items-center gap-1.5 ${
                activeTab === 'messages'
                  ? 'bg-rose-600 text-white shadow-xs'
                  : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800'
              }`}
            >
              <Inbox className="w-3.5 h-3.5" />
              <span>Inquiries ({messages.length})</span>
              {unreadCount > 0 && (
                <span className="w-4 h-4 rounded-full bg-rose-500 text-white text-[10px] flex items-center justify-center font-bold">
                  {unreadCount}
                </span>
              )}
            </button>

            <button
              onClick={() => setActiveTab('database')}
              className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer flex items-center gap-1.5 ${
                activeTab === 'database'
                  ? 'bg-rose-600 text-white shadow-xs'
                  : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800'
              }`}
            >
              <Database className="w-3.5 h-3.5" />
              <span>MySQL Schemas & Tables</span>
            </button>

            <button
              onClick={() => setActiveTab('overview')}
              className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition-all cursor-pointer flex items-center gap-1.5 ${
                activeTab === 'overview'
                  ? 'bg-rose-600 text-white shadow-xs'
                  : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800'
              }`}
            >
              <Layers className="w-3.5 h-3.5" />
              <span>Portfolio Metrics</span>
            </button>
          </div>

          {activeTab === 'messages' && (
            <div className="flex items-center gap-1 text-xs">
              <span className="text-neutral-500 hidden sm:inline">Filter:</span>
              {(['All', 'Unread', 'Read', 'Replied'] as const).map((status) => (
                <button
                  key={status}
                  onClick={() => setFilterStatus(status)}
                  className={`px-2.5 py-1 rounded-md text-[11px] font-medium transition-colors cursor-pointer ${
                    filterStatus === status
                      ? 'bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 font-bold'
                      : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800'
                  }`}
                >
                  {status}
                </button>
              ))}
            </div>
          )}
        </div>

        {/* Tab 1: Messages Split View */}
        {activeTab === 'messages' && (
          <div className="flex-1 grid grid-cols-1 md:grid-cols-12 overflow-hidden">
            
            {/* Left Column: Messages List */}
            <div className="md:col-span-5 border-r border-neutral-200 dark:border-neutral-800 overflow-y-auto divide-y divide-neutral-100 dark:divide-neutral-800/80 bg-neutral-50/50 dark:bg-neutral-950/20">
              {filteredMessages.length === 0 ? (
                <div className="p-8 text-center text-neutral-400 text-xs">
                  No messages found for this filter.
                </div>
              ) : (
                filteredMessages.map((msg) => {
                  const isSelected = selectedMessage?.id === msg.id;
                  return (
                    <div
                      key={msg.id}
                      onClick={() => {
                        setSelectedMessage(msg);
                        if (msg.status === 'Unread') {
                          onUpdateStatus(msg.id, 'Read');
                        }
                      }}
                      className={`p-4 cursor-pointer transition-colors relative ${
                        isSelected
                          ? 'bg-white dark:bg-neutral-800/90 border-l-4 border-rose-600 shadow-xs'
                          : 'hover:bg-neutral-100/70 dark:hover:bg-neutral-900/60'
                      }`}
                    >
                      <div className="flex items-center justify-between gap-2 mb-1">
                        <span className="font-bold text-xs text-neutral-900 dark:text-white truncate">
                          {msg.name}
                        </span>
                        <span
                          className={`text-[10px] font-semibold px-2 py-0.5 rounded-full ${
                            msg.status === 'Unread'
                              ? 'bg-rose-500/10 text-rose-500 font-bold animate-pulse'
                              : msg.status === 'Read'
                              ? 'bg-sky-500/10 text-sky-500'
                              : 'bg-emerald-500/10 text-emerald-500'
                          }`}
                        >
                          {msg.status}
                        </span>
                      </div>

                      <div className="text-xs font-semibold text-neutral-800 dark:text-neutral-200 truncate mb-1">
                        {msg.subject}
                      </div>

                      <p className="text-[11px] text-neutral-500 line-clamp-2 leading-normal">
                        {msg.message}
                      </p>

                      <div className="mt-2 text-[10px] text-neutral-400 flex items-center justify-between">
                        <span>{msg.email}</span>
                        <span>{msg.createdAt}</span>
                      </div>
                    </div>
                  );
                })
              )}
            </div>

            {/* Right Column: Selected Message Reader & Action Console */}
            <div className="md:col-span-7 p-6 overflow-y-auto flex flex-col justify-between bg-white dark:bg-[#12141c]">
              {selectedMessage ? (
                <div className="space-y-6">
                  {/* Status Banner & Action Buttons */}
                  <div className="flex items-center justify-between pb-4 border-b border-neutral-200 dark:border-neutral-800 flex-wrap gap-2">
                    <div className="flex items-center gap-2">
                      <span className="text-xs font-semibold text-neutral-500">Status:</span>
                      <select
                        value={selectedMessage.status}
                        onChange={(e) =>
                          onUpdateStatus(
                            selectedMessage.id,
                            e.target.value as 'Unread' | 'Read' | 'Replied'
                          )
                        }
                        className="text-xs font-bold px-2.5 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200"
                      >
                        <option value="Unread">Unread</option>
                        <option value="Read">Read</option>
                        <option value="Replied">Replied</option>
                      </select>
                    </div>

                    <div className="flex items-center gap-2">
                      <button
                        onClick={() => onDeleteMessage(selectedMessage.id)}
                        className="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors"
                        title="Delete Message"
                      >
                        <Trash2 className="w-4 h-4" />
                      </button>
                    </div>
                  </div>

                  {/* Sender Details */}
                  <div className="p-4 rounded-2xl bg-neutral-50 dark:bg-neutral-900/60 border border-neutral-200 dark:border-neutral-800 space-y-2">
                    <div className="flex justify-between items-start">
                      <div>
                        <h3 className="text-lg font-bold text-neutral-900 dark:text-white">
                          {selectedMessage.name}
                        </h3>
                        <div className="flex items-center gap-4 text-xs text-neutral-500 mt-1 flex-wrap">
                          <a
                            href={`mailto:${selectedMessage.email}`}
                            className="flex items-center gap-1 text-rose-600 dark:text-rose-400 hover:underline"
                          >
                            <Mail className="w-3.5 h-3.5" />
                            <span>{selectedMessage.email}</span>
                          </a>

                          {selectedMessage.phone && (
                            <a
                              href={`tel:${selectedMessage.phone}`}
                              className="flex items-center gap-1 text-neutral-700 dark:text-neutral-300 hover:underline"
                            >
                              <Phone className="w-3.5 h-3.5 text-emerald-500" />
                              <span>{selectedMessage.phone}</span>
                            </a>
                          )}
                        </div>
                      </div>

                      <span className="text-[11px] text-neutral-400">
                        {selectedMessage.createdAt}
                      </span>
                    </div>
                  </div>

                  {/* Message Subject & Body */}
                  <div>
                    <h4 className="text-sm font-bold uppercase tracking-wider text-neutral-400 mb-2">
                      Subject: <span className="text-neutral-900 dark:text-white font-heading text-base normal-case">{selectedMessage.subject}</span>
                    </h4>
                    <div className="p-5 rounded-2xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 text-sm sm:text-base leading-relaxed text-neutral-800 dark:text-neutral-200 whitespace-pre-line shadow-xs">
                      {selectedMessage.message}
                    </div>
                  </div>

                  {/* Quick Reply Actions */}
                  <div className="pt-4 border-t border-neutral-200 dark:border-neutral-800 flex flex-wrap gap-3">
                    <a
                      href={`mailto:${selectedMessage.email}?subject=Re:%20${encodeURIComponent(selectedMessage.subject)}`}
                      onClick={() => onUpdateStatus(selectedMessage.id, 'Replied')}
                      className="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 transition-colors"
                    >
                      <Mail className="w-3.5 h-3.5" />
                      <span>Reply via Email</span>
                    </a>

                    {selectedMessage.phone && (
                      <a
                        href={`https://wa.me/${selectedMessage.phone.replace(/[^0-9]/g, '')}?text=Hello%20${encodeURIComponent(selectedMessage.name)},%20thank%20you%20for%20contacting%20me%20regarding%20${encodeURIComponent(selectedMessage.subject)}.`}
                        target="_blank"
                        rel="noopener noreferrer"
                        onClick={() => onUpdateStatus(selectedMessage.id, 'Replied')}
                        className="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors"
                      >
                        <MessageSquare className="w-3.5 h-3.5" />
                        <span>Reply on WhatsApp</span>
                      </a>
                    )}
                  </div>
                </div>
              ) : (
                <div className="flex flex-col items-center justify-center h-full text-neutral-400 space-y-2">
                  <Inbox className="w-10 h-10 stroke-1" />
                  <p className="text-xs">Select a message from the list to view full details.</p>
                </div>
              )}
            </div>

          </div>
        )}

        {/* Tab 2: Database Schemas & Tables */}
        {activeTab === 'database' && (
          <div className="flex-1 p-6 overflow-y-auto space-y-6 bg-white dark:bg-[#12141c]">
            <div>
              <h3 className="text-lg font-bold font-heading text-neutral-900 dark:text-white mb-1">
                MySQL Relational Database Schema (`database.sql`)
              </h3>
              <p className="text-xs text-neutral-500 dark:text-neutral-400">
                Configured with 4 core tables: contact_messages, projects, design_gallery, and social_links.
              </p>
            </div>

            <div className="space-y-4">
              {/* Table 1: contact_messages */}
              <div className="p-4 rounded-xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                <div className="flex items-center justify-between mb-2">
                  <span className="font-code font-bold text-xs text-rose-500">TABLE contact_messages</span>
                  <span className="text-[11px] text-neutral-500 font-mono">InnoDB • UTF8MB4</span>
                </div>
                <div className="text-xs font-mono text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-950 p-3 rounded-lg border border-neutral-200 dark:border-neutral-800 overflow-x-auto">
                  id INT AUTO_INCREMENT PRIMARY KEY,<br />
                  name VARCHAR(100) NOT NULL,<br />
                  email VARCHAR(150) NOT NULL,<br />
                  phone VARCHAR(30) NULL,<br />
                  subject VARCHAR(200) NOT NULL,<br />
                  message TEXT NOT NULL,<br />
                  status ENUM('Unread', 'Read', 'Replied') DEFAULT 'Unread',<br />
                  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                </div>
              </div>

              {/* Table 2: projects */}
              <div className="p-4 rounded-xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                <div className="flex items-center justify-between mb-2">
                  <span className="font-code font-bold text-xs text-sky-500">TABLE projects</span>
                  <span className="text-[11px] text-neutral-500 font-mono">InnoDB • UTF8MB4</span>
                </div>
                <div className="text-xs font-mono text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-950 p-3 rounded-lg border border-neutral-200 dark:border-neutral-800 overflow-x-auto">
                  id INT AUTO_INCREMENT PRIMARY KEY,<br />
                  title VARCHAR(200) NOT NULL,<br />
                  category ENUM('Web Development', 'Graphic Design', 'UI/UX') NOT NULL,<br />
                  description TEXT NOT NULL,<br />
                  technologies VARCHAR(255) NOT NULL,<br />
                  image VARCHAR(255) NOT NULL,<br />
                  github_url VARCHAR(255) NULL,<br />
                  live_url VARCHAR(255) NULL,<br />
                  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                </div>
              </div>
            </div>
          </div>
        )}

        {/* Tab 3: Metrics Overview */}
        {activeTab === 'overview' && (
          <div className="flex-1 p-6 overflow-y-auto space-y-6 bg-white dark:bg-[#12141c]">
            <h3 className="text-lg font-bold font-heading text-neutral-900 dark:text-white">
              Portfolio Ingestion & Status Overview
            </h3>

            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div className="p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                <div className="text-xs text-neutral-500 font-semibold uppercase">Total Messages</div>
                <div className="text-3xl font-extrabold font-heading text-neutral-900 dark:text-white mt-1">
                  {messages.length}
                </div>
                <div className="text-[11px] text-neutral-400 mt-1">Stored inquiries</div>
              </div>

              <div className="p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                <div className="text-xs text-rose-500 font-semibold uppercase">Unread Messages</div>
                <div className="text-3xl font-extrabold font-heading text-rose-600 dark:text-rose-400 mt-1">
                  {unreadCount}
                </div>
                <div className="text-[11px] text-neutral-400 mt-1">Requiring review</div>
              </div>

              <div className="p-5 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                <div className="text-xs text-emerald-500 font-semibold uppercase">Replied Messages</div>
                <div className="text-3xl font-extrabold font-heading text-emerald-600 dark:text-emerald-400 mt-1">
                  {repliedCount}
                </div>
                <div className="text-[11px] text-neutral-400 mt-1">Completed inquiries</div>
              </div>
            </div>

            <div className="p-5 rounded-2xl bg-rose-50 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-900/40 text-xs text-neutral-700 dark:text-neutral-300 space-y-2">
              <div className="font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                <CheckCircle className="w-4 h-4 text-rose-500" />
                <span>Production PHP Server Package is fully generated in `/rasindu-portfolio/`</span>
              </div>
              <p>
                All templates, PDO database connections, security filters, XAMPP instructions, and admin scripts are available in the repository files and exportable on demand.
              </p>
            </div>
          </div>
        )}

      </div>
    </div>
  );
};
