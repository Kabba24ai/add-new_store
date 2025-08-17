import React, { useState } from 'react';
import { StoreForm } from './components/StoreForm';
import { Building2, Plus, CheckCircle } from 'lucide-react';

interface StoreData {
  storeName: string;
  phone: string;
  email: string;
  address: string;
  city: string;
  state: string;
  zip: string;
  designation: 'primary' | 'alternate';
  isActive: boolean;
}

function App() {
  const [showSuccess, setShowSuccess] = useState(false);
  const [isEditing, setIsEditing] = useState(false);
  const [currentStore, setCurrentStore] = useState<StoreData | null>(null);

  const handleSaveStore = (storeData: StoreData) => {
    console.log('Saving store:', storeData);
    
    // Simulate API call success
    setShowSuccess(true);
    setTimeout(() => setShowSuccess(false), 3000);
    
    // Reset form state
    setCurrentStore(null);
    setIsEditing(false);
  };

  const handleCancel = () => {
    setCurrentStore(null);
    setIsEditing(false);
  };

  const handleEditDemo = () => {
    setCurrentStore({
      storeName: 'Downtown Electronics',
      phone: '(555) 123-4567',
      email: 'downtown@electronics.com',
      address: '123 Main Street',
      city: 'San Francisco',
      state: 'CA',
      zip: '94102',
      designation: 'primary',
      isActive: true,
    });
    setIsEditing(true);
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
      {/* Header */}
      <div className="bg-white shadow-sm border-b border-gray-200">
        <div className="max-w-6xl mx-auto px-6 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-3">
              <div className="p-2 bg-blue-100 rounded-lg">
                <Building2 className="w-8 h-8 text-blue-600" />
              </div>
              <div>
                <h1 className="text-2xl font-bold text-gray-900">Store Management</h1>
                <p className="text-gray-600">Manage your rental store locations</p>
              </div>
            </div>
            <button
              onClick={handleEditDemo}
              className="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors"
            >
              <Plus className="w-4 h-4" />
              Demo Edit Mode
            </button>
          </div>
        </div>
      </div>

      {/* Success Message */}
      {showSuccess && (
        <div className="fixed top-4 right-4 z-50 bg-green-100 border border-green-300 text-green-800 px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 animate-pulse">
          <CheckCircle className="w-5 h-5 text-green-600" />
          <span className="font-medium">Store saved successfully!</span>
        </div>
      )}

      {/* Main Content */}
      <div className="py-8">
        <StoreForm
          initialData={currentStore || undefined}
          onSave={handleSaveStore}
          onCancel={handleCancel}
          isEditing={isEditing}
        />
      </div>

      {/* Footer */}
      <div className="mt-16 py-8 text-center text-gray-500 text-sm">
        <p>Store Management System - Built for Rental & E-commerce</p>
      </div>
    </div>
  );
}

export default App;