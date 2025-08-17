import React, { useState } from 'react';
import StoreForm from './components/StoreForm';
import SettingsPage from './components/SettingsPage';
import './App.css';

function App() {
  const [currentView, setCurrentView] = useState<'stores' | 'add-store' | 'settings'>('stores');
  const [editingStore, setEditingStore] = useState<any>(null);

  const handleAddStore = () => {
    setEditingStore(null);
    setCurrentView('add-store');
  };

  const handleEditStore = (store: any) => {
    setEditingStore(store);
    setCurrentView('add-store');
  };

  const handleSaveStore = (store: any) => {
    // Handle save logic here
    setCurrentView('stores');
  };

  const handleCancelEdit = () => {
    setEditingStore(null);
    setCurrentView('stores');
  };

  const handleViewSettings = () => {
    setCurrentView('settings');
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
      {/* Navigation */}
      <nav className="bg-white shadow-sm border-b border-gray-200">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-16">
            <div className="flex items-center">
              <h1 className="text-xl font-bold text-gray-900">Store Manager</h1>
            </div>
            
            {/* Navigation Links */}
            <div className="hidden md:block">
              <div className="ml-10 flex items-baseline space-x-4">
                {/* Navigation items will go here */}
              </div>
            </div>
            
            {/* Right side navigation */}
            <div className="flex items-center space-x-4">
              <button
                onClick={() => setCurrentView('stores')}
                className={`text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors ${currentView === 'stores' ? 'bg-blue-50 text-blue-600' : ''}`}
              >
                All Stores
              </button>
              <button
                onClick={handleViewSettings}
                className={`text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors ${currentView === 'stores' ? 'bg-blue-50 text-blue-600' : ''}`}
              >
                Settings
              </button>
              <button
                onClick={handleAddStore}
                className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors"
              >
                Add Store
              </button>
            </div>
          </div>
        </div>
      </nav>

      {/* Main Content */}
      <main className="py-8">
        {currentView === 'add-store' && (
          <StoreForm store={editingStore} onSave={handleSaveStore} onCancel={handleCancelEdit} />
        )}
        {currentView === 'settings' && (
          <SettingsPage />
        )}
        {currentView === 'stores' && (
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {/* Store list content will go here */}
          </div>
        )}
      </main>
    </div>
  );
}

export default App;