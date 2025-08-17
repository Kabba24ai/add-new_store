@@ .. @@
 import React, { useState } from 'react';
 import StoreForm from './components/StoreForm';
+import SettingsPage from './components/SettingsPage';
 import './App.css';
 
 function App() {
-  const [currentView, setCurrentView] = useState<'stores' | 'add-store'>('stores');
+  const [currentView, setCurrentView] = useState<'stores' | 'add-store' | 'settings'>('stores');
   const [editingStore, setEditingStore] = useState<any>(null);
 
   const handleAddStore = () => {
@@ -25,6 +26,10 @@ function App() {
     setCurrentView('stores');
   };
 
+  const handleViewSettings = () => {
+    setCurrentView('settings');
+  };
+
   return (
     <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
       {/* Navigation */}
@@ -47,6 +52,12 @@ function App() {
           <div className="flex items-center space-x-4">
             <button
               onClick={() => setCurrentView('stores')}
+              className={`text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors ${currentView === 'stores' ? 'bg-blue-50 text-blue-600' : ''}`}
+            >
+              All Stores
+            </button>
+            <button
+              onClick={handleViewSettings}
               className={`text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors ${currentView === 'stores' ? 'bg-blue-50 text-blue-600' : ''}`}
             >
               Settings
@@ -67,6 +78,8 @@ function App() {
       <main className="py-8">
         {currentView === 'add-store' && (
           <StoreForm store={editingStore} onSave={handleSaveStore} onCancel={handleCancelEdit} />
+        )}
+        {currentView === 'settings' && (
+          <SettingsPage />
         )}
         {currentView === 'stores' && (
           <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">