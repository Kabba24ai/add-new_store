import React, { useState } from 'react';
import { Save, X, MapPin, Phone, Mail, Building2 } from 'lucide-react';
import { US_STATES } from '../constants/states';

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

interface StoreFormProps {
  initialData?: Partial<StoreData>;
  onSave: (data: StoreData) => void;
  onCancel: () => void;
  isEditing?: boolean;
}

export function StoreForm({ initialData, onSave, onCancel, isEditing = false }: StoreFormProps) {
  const [formData, setFormData] = useState<StoreData>({
    storeName: initialData?.storeName || '',
    phone: initialData?.phone || '',
    email: initialData?.email || '',
    address: initialData?.address || '',
    city: initialData?.city || '',
    state: initialData?.state || '',
    zip: initialData?.zip || '',
    designation: initialData?.designation || 'alternate',
    isActive: initialData?.isActive ?? true,
  });

  const [errors, setErrors] = useState<Partial<Record<keyof StoreData, string>>>({});

  const validateForm = (): boolean => {
    const newErrors: Partial<Record<keyof StoreData, string>> = {};

    if (!formData.storeName.trim()) {
      newErrors.storeName = 'Store name is required';
    }

    if (!formData.phone.trim()) {
      newErrors.phone = 'Phone number is required';
    } else if (!/^\(\d{3}\) \d{3}-\d{4}$/.test(formData.phone)) {
      newErrors.phone = 'Phone format: (555) 123-4567';
    }

    if (!formData.email.trim()) {
      newErrors.email = 'Email is required';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      newErrors.email = 'Please enter a valid email';
    }

    if (!formData.address.trim()) {
      newErrors.address = 'Address is required';
    }

    if (!formData.city.trim()) {
      newErrors.city = 'City is required';
    }

    if (!formData.state) {
      newErrors.state = 'State is required';
    }

    if (!formData.zip.trim()) {
      newErrors.zip = 'ZIP code is required';
    } else if (!/^\d{5}(-\d{4})?$/.test(formData.zip)) {
      newErrors.zip = 'ZIP format: 12345 or 12345-6789';
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleInputChange = (field: keyof StoreData, value: string | boolean) => {
    setFormData(prev => ({ ...prev, [field]: value }));
    if (errors[field]) {
      setErrors(prev => ({ ...prev, [field]: undefined }));
    }
  };

  const formatPhoneNumber = (value: string) => {
    const cleaned = value.replace(/\D/g, '');
    const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
    if (match) {
      return `(${match[1]}) ${match[2]}-${match[3]}`;
    }
    return value;
  };

  const handlePhoneChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const formatted = formatPhoneNumber(e.target.value);
    handleInputChange('phone', formatted);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (validateForm()) {
      onSave(formData);
    }
  };

  return (
    <div className="max-w-4xl mx-auto p-6">
      <div className="bg-white rounded-xl shadow-lg border border-gray-100">
        <div className="px-8 py-6 border-b border-gray-100">
          <div className="flex items-center gap-3">
            <div className="p-2 bg-blue-100 rounded-lg">
              <Building2 className="w-6 h-6 text-blue-600" />
            </div>
            <div>
              <h1 className="text-2xl font-bold text-gray-900">
                {isEditing ? 'Edit Store' : 'Add New Store'}
              </h1>
              <p className="text-gray-600 mt-1">
                {isEditing ? 'Update store information' : 'Enter store details to add a new location'}
              </p>
            </div>
          </div>
        </div>

        <form onSubmit={handleSubmit} className="p-8 space-y-8">
          {/* Store Name */}
          <div className="space-y-2">
            <label htmlFor="storeName" className="block text-sm font-semibold text-gray-800">
              Store Name
            </label>
            <input
              type="text"
              id="storeName"
              value={formData.storeName}
              onChange={(e) => handleInputChange('storeName', e.target.value)}
              className={`w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent ${
                errors.storeName ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
              }`}
              placeholder="Enter store name"
            />
            {errors.storeName && (
              <p className="text-sm text-red-600 flex items-center gap-1">
                <X className="w-4 h-4" />
                {errors.storeName}
              </p>
            )}
          </div>

          {/* Contact Information Row */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="space-y-2">
              <label htmlFor="phone" className="block text-sm font-semibold text-gray-800">
                <Phone className="w-4 h-4 inline mr-2" />
                Phone Number
              </label>
              <input
                type="tel"
                id="phone"
                value={formData.phone}
                onChange={handlePhoneChange}
                className={`w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent ${
                  errors.phone ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                }`}
                placeholder="(555) 123-4567"
              />
              {errors.phone && (
                <p className="text-sm text-red-600 flex items-center gap-1">
                  <X className="w-4 h-4" />
                  {errors.phone}
                </p>
              )}
            </div>

            <div className="space-y-2">
              <label htmlFor="email" className="block text-sm font-semibold text-gray-800">
                <Mail className="w-4 h-4 inline mr-2" />
                Email Address
              </label>
              <input
                type="email"
                id="email"
                value={formData.email}
                onChange={(e) => handleInputChange('email', e.target.value)}
                className={`w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent ${
                  errors.email ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                }`}
                placeholder="store@company.com"
              />
              {errors.email && (
                <p className="text-sm text-red-600 flex items-center gap-1">
                  <X className="w-4 h-4" />
                  {errors.email}
                </p>
              )}
            </div>
          </div>

          {/* Address Section */}
          <div className="space-y-6">
            <div className="flex items-center gap-2 text-gray-800 font-semibold">
              <MapPin className="w-5 h-5" />
              <span>Store Address</span>
            </div>

            <div className="space-y-2">
              <label htmlFor="address" className="block text-sm font-semibold text-gray-800">
                Street Address
              </label>
              <input
                type="text"
                id="address"
                value={formData.address}
                onChange={(e) => handleInputChange('address', e.target.value)}
                className={`w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent ${
                  errors.address ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                }`}
                placeholder="123 Main Street"
              />
              {errors.address && (
                <p className="text-sm text-red-600 flex items-center gap-1">
                  <X className="w-4 h-4" />
                  {errors.address}
                </p>
              )}
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div className="space-y-2">
                <label htmlFor="city" className="block text-sm font-semibold text-gray-800">
                  City
                </label>
                <input
                  type="text"
                  id="city"
                  value={formData.city}
                  onChange={(e) => handleInputChange('city', e.target.value)}
                  className={`w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent ${
                    errors.city ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                  }`}
                  placeholder="Enter city"
                />
                {errors.city && (
                  <p className="text-sm text-red-600 flex items-center gap-1">
                    <X className="w-4 h-4" />
                    {errors.city}
                  </p>
                )}
              </div>

              <div className="space-y-2">
                <label htmlFor="state" className="block text-sm font-semibold text-gray-800">
                  State
                </label>
                <select
                  id="state"
                  value={formData.state}
                  onChange={(e) => handleInputChange('state', e.target.value)}
                  className={`w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent ${
                    errors.state ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                  }`}
                >
                  <option value="">Select State</option>
                  {US_STATES.map((state) => (
                    <option key={state.value} value={state.value}>
                      {state.label}
                    </option>
                  ))}
                </select>
                {errors.state && (
                  <p className="text-sm text-red-600 flex items-center gap-1">
                    <X className="w-4 h-4" />
                    {errors.state}
                  </p>
                )}
              </div>

              <div className="space-y-2">
                <label htmlFor="zip" className="block text-sm font-semibold text-gray-800">
                  ZIP Code
                </label>
                <input
                  type="text"
                  id="zip"
                  value={formData.zip}
                  onChange={(e) => handleInputChange('zip', e.target.value)}
                  className={`w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent ${
                    errors.zip ? 'border-red-300 bg-red-50' : 'border-gray-300 hover:border-gray-400'
                  }`}
                  placeholder="12345"
                />
                {errors.zip && (
                  <p className="text-sm text-red-600 flex items-center gap-1">
                    <X className="w-4 h-4" />
                    {errors.zip}
                  </p>
                )}
              </div>
            </div>
          </div>

          {/* Store Settings */}
          <div className="space-y-6">
            <h3 className="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">
              Store Settings
            </h3>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
              {/* Store Designation */}
              <div className="space-y-3">
                <label className="block text-sm font-semibold text-gray-800">
                  Store Designation
                </label>
                <div className="space-y-2">
                  <label className="flex items-center space-x-3 cursor-pointer group">
                    <input
                      type="radio"
                      name="designation"
                      value="primary"
                      checked={formData.designation === 'primary'}
                      onChange={(e) => handleInputChange('designation', e.target.value as 'primary' | 'alternate')}
                      className="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                    />
                    <span className="text-gray-700 group-hover:text-gray-900 transition-colors">
                      Primary Store
                    </span>
                  </label>
                  <label className="flex items-center space-x-3 cursor-pointer group">
                    <input
                      type="radio"
                      name="designation"
                      value="alternate"
                      checked={formData.designation === 'alternate'}
                      onChange={(e) => handleInputChange('designation', e.target.value as 'primary' | 'alternate')}
                      className="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                    />
                    <span className="text-gray-700 group-hover:text-gray-900 transition-colors">
                      Alternate Store
                    </span>
                  </label>
                </div>
              </div>

              {/* Active Status */}
              <div className="space-y-3">
                <label className="block text-sm font-semibold text-gray-800">
                  Store Status
                </label>
                <div className="flex items-center space-x-4">
                  <button
                    type="button"
                    onClick={() => handleInputChange('isActive', !formData.isActive)}
                    className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 ${
                      formData.isActive ? 'bg-green-500' : 'bg-gray-300'
                    }`}
                  >
                    <span
                      className={`inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 ${
                        formData.isActive ? 'translate-x-6' : 'translate-x-1'
                      }`}
                    />
                  </button>
                  <span className={`text-sm font-medium ${
                    formData.isActive ? 'text-green-700' : 'text-gray-700'
                  }`}>
                    {formData.isActive ? 'Active' : 'Inactive'}
                  </span>
                </div>
              </div>
            </div>
          </div>

          {/* Action Buttons */}
          <div className="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
            <button
              type="submit"
              className="flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105"
            >
              <Save className="w-5 h-5" />
              {isEditing ? 'Update Store' : 'Save Store'}
            </button>
            <button
              type="button"
              onClick={onCancel}
              className="flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200"
            >
              <X className="w-5 h-5" />
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}