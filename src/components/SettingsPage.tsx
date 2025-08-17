import React, { useState, useEffect } from 'react';
import { ChevronRightIcon, ShieldCheckIcon, PhoneIcon, CreditCardIcon, CogIcon } from '@heroicons/react/24/outline';

interface Setting {
  [key: string]: string | boolean;
}

interface FieldConfig {
  label: string;
  type: string;
  required?: boolean;
  encrypted?: boolean;
  description?: string;
  options?: { [key: string]: string } | string[];
  step?: string;
  min?: string;
  max?: string;
  suffix?: string;
}

interface SectionConfig {
  title: string;
  description: string;
  icon: string;
  fields: { [key: string]: FieldConfig };
}

const SettingsPage: React.FC = () => {
  const [activeSection, setActiveSection] = useState('admin');
  const [settings, setSettings] = useState<{ [section: string]: Setting }>({
    admin: {
      master_passcode: '',
    },
    contact: {
      contact_phone: '(555) 123-4567',
      contact_email_general: 'info@company.com',
      contact_email_sales: 'sales@company.com',
      contact_email_complaints: 'complaints@company.com',
      contact_email_feedback: 'feedback@company.com',
      contact_note: 'Store locations and addresses are managed in the Stores Settings section.',
    },
    payment: {
      payment_gateway: 'Stripe',
      payment_api_public_key: 'pk_test_example_public_key',
      payment_api_key: 'sk_test_example_api_key',
      payment_api_secret_key: '',
      payment_test_mode: true,
    },
    product: {
      sales_tax: '8.25',
      standard_delivery_range: '25',
      extended_delivery_range: '50',
      include_extended_range: true,
      distance_units: 'miles',
    },
  });

  const [isPasscodeVerified, setIsPasscodeVerified] = useState(false);
  const [passcodeInput, setPasscodeInput] = useState('');
  const [showSuccess, setShowSuccess] = useState(false);
  const [showError, setShowError] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');
  const [formData, setFormData] = useState<Setting>({});

  const sections = {
    admin: 'Admin Control',
    contact: 'Contact Us',
    payment: 'Payment Integration',
    product: 'Product Settings'
  };

  const settingsConfig: { [key: string]: SectionConfig } = {
    admin: {
      title: 'Admin Control',
      description: 'Administrative settings and security configuration',
      icon: 'shield-check',
      fields: {
        master_passcode: {
          label: 'Master Passcode',
          type: 'password',
          encrypted: true,
          description: 'Must be encrypted. Required to access/edit encrypted Master Passcode.',
          required: false,
        },
      }
    },
    contact: {
      title: 'Contact Us - Website Contact Page',
      description: 'Contact information displayed on your website',
      icon: 'phone',
      fields: {
        contact_phone: {
          label: 'Phone',
          type: 'tel',
          description: 'Use defined phone format for USA (xxx) xxx-xxxx',
          required: true,
        },
        contact_email_general: {
          label: 'Email - General',
          type: 'email',
          required: true,
        },
        contact_email_sales: {
          label: 'Email - Sales Inquiry',
          type: 'email',
          required: true,
        },
        contact_email_complaints: {
          label: 'Email - Complaints',
          type: 'email',
          required: true,
        },
        contact_email_feedback: {
          label: 'Email - Feedback',
          type: 'email',
          required: true,
        },
        contact_note: {
          label: 'Note to Other People',
          type: 'textarea',
          description: 'Store locations/addresses that appear on the Contact Us page are in Stores Settings (make the Stores Settings a hyperlink to the Stores Settings page - add this as a note for the programming team)',
          required: false,
        },
      }
    },
    payment: {
      title: 'Payment Integration',
      description: 'Payment gateway and API configuration',
      icon: 'credit-card',
      fields: {
        payment_gateway: {
          label: 'Payment Gateway',
          type: 'text',
          required: true,
        },
        payment_api_public_key: {
          label: 'Payment API - Public Key',
          type: 'text',
          required: true,
        },
        payment_api_key: {
          label: 'Payment API Key',
          type: 'text',
          encrypted: true,
          required: true,
        },
        payment_api_secret_key: {
          label: 'Payment API Secret Key',
          type: 'password',
          encrypted: true,
          description: 'Must be encrypted',
          required: true,
        },
        payment_test_mode: {
          label: 'Payment Test Mode',
          type: 'radio',
          options: ['Yes', 'No'],
          description: 'Yes or No (drop down or radio buttons)',
          required: true,
        },
      }
    },
    product: {
      title: 'Product Settings',
      description: 'Sales tax, delivery ranges, and product configuration',
      icon: 'cog',
      fields: {
        sales_tax: {
          label: 'Sales Tax',
          type: 'number',
          step: '0.01',
          min: '0',
          max: '100',
          suffix: '%',
          required: true,
        },
        standard_delivery_range: {
          label: 'Standard Delivery Range - Up To',
          type: 'number',
          step: '0.1',
          min: '0',
          description: 'Numerical distance number',
          required: true,
        },
        extended_delivery_range: {
          label: 'Extended Delivery Range - Up To',
          type: 'number',
          step: '0.1',
          min: '0',
          description: 'Numerical distance number',
          required: true,
        },
        include_extended_range: {
          label: 'Include Extended Range Option',
          type: 'checkbox',
          required: false,
        },
        distance_units: {
          label: 'Distance Units',
          type: 'select',
          options: { miles: 'Miles', kilometers: 'Kilometers' },
          required: true,
        },
      }
    }
  };

  useEffect(() => {
    setFormData(settings[activeSection] || {});
  }, [activeSection, settings]);

  const requiresPasscodeVerification = () => {
    return ['admin', 'payment'].includes(activeSection) && !isPasscodeVerified;
  };

  const handlePasscodeVerification = (e: React.FormEvent) => {
    e.preventDefault();
    // Demo: accept "admin123" as valid passcode
    if (passcodeInput === 'admin123') {
      setIsPasscodeVerified(true);
      setPasscodeInput('');
      setShowSuccess(true);
      setTimeout(() => setShowSuccess(false), 3000);
    } else {
      setErrorMessage('Invalid master passcode. Please try again.');
      setShowError(true);
      setTimeout(() => setShowError(false), 3000);
    }
  };

  const clearPasscodeVerification = () => {
    setIsPasscodeVerified(false);
    setShowSuccess(true);
    setTimeout(() => setShowSuccess(false), 3000);
  };

  const formatPhoneNumber = (value: string) => {
    const cleaned = value.replace(/\D/g, '');
    if (cleaned.length >= 6) {
      return cleaned.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
    } else if (cleaned.length >= 3) {
      return cleaned.replace(/(\d{3})(\d{0,3})/, '($1) $2');
    }
    return cleaned;
  };

  const handleInputChange = (fieldKey: string, value: string | boolean) => {
    if (fieldKey === 'contact_phone' && typeof value === 'string') {
      value = formatPhoneNumber(value);
    }
    
    setFormData(prev => ({
      ...prev,
      [fieldKey]: value
    }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    // Update settings
    setSettings(prev => ({
      ...prev,
      [activeSection]: { ...formData }
    }));

    setShowSuccess(true);
    setTimeout(() => setShowSuccess(false), 3000);
  };

  const renderIcon = (iconName: string, className: string = "w-6 h-6") => {
    switch (iconName) {
      case 'shield-check':
        return <ShieldCheckIcon className={className} />;
      case 'phone':
        return <PhoneIcon className={className} />;
      case 'credit-card':
        return <CreditCardIcon className={className} />;
      case 'cog':
        return <CogIcon className={className} />;
      default:
        return <CogIcon className={className} />;
    }
  };

  const renderField = (fieldKey: string, fieldConfig: FieldConfig) => {
    const value = formData[fieldKey] || '';

    if (fieldConfig.type === 'textarea') {
      return (
        <textarea
          id={fieldKey}
          value={value as string}
          onChange={(e) => handleInputChange(fieldKey, e.target.value)}
          rows={4}
          className="w-full px-4 py-3 rounded-lg border border-gray-300 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          placeholder={fieldConfig.description || ''}
          required={fieldConfig.required}
        />
      );
    }

    if (fieldConfig.type === 'select') {
      return (
        <select
          id={fieldKey}
          value={value as string}
          onChange={(e) => handleInputChange(fieldKey, e.target.value)}
          className="w-full px-4 py-3 rounded-lg border border-gray-300 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          required={fieldConfig.required}
        >
          {fieldConfig.options && typeof fieldConfig.options === 'object' && !Array.isArray(fieldConfig.options) ? 
            Object.entries(fieldConfig.options).map(([optionValue, label]) => (
              <option key={optionValue} value={optionValue}>
                {label}
              </option>
            )) :
            Array.isArray(fieldConfig.options) && fieldConfig.options.map((option, index) => (
              <option key={index} value={index}>
                {option}
              </option>
            ))
          }
        </select>
      );
    }

    if (fieldConfig.type === 'radio') {
      return (
        <div className="space-y-2">
          {Array.isArray(fieldConfig.options) && fieldConfig.options.map((option, index) => (
            <label key={index} className="flex items-center space-x-3 cursor-pointer group">
              <input
                type="radio"
                name={fieldKey}
                value={index}
                checked={value === index || (index === 0 && value === true) || (index === 1 && value === false)}
                onChange={(e) => handleInputChange(fieldKey, index === 0)}
                className="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                required={fieldConfig.required}
              />
              <span className="text-gray-700 group-hover:text-gray-900 transition-colors">
                {option}
              </span>
            </label>
          ))}
        </div>
      );
    }

    if (fieldConfig.type === 'checkbox') {
      return (
        <div className="flex items-center space-x-3">
          <input
            type="checkbox"
            id={fieldKey}
            checked={value as boolean}
            onChange={(e) => handleInputChange(fieldKey, e.target.checked)}
            className="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
          />
          <label htmlFor={fieldKey} className="text-gray-700 cursor-pointer">
            Enable this option
          </label>
        </div>
      );
    }

    if (fieldKey === 'master_passcode') {
      return (
        <div className="space-y-4">
          <input
            type="password"
            id={fieldKey}
            value={value as string}
            onChange={(e) => handleInputChange(fieldKey, e.target.value)}
            className="w-full px-4 py-3 rounded-lg border border-gray-300 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Enter new master passcode (leave blank to keep current)"
          />
          <input
            type="password"
            id="master_passcode_confirmation"
            className="w-full px-4 py-3 rounded-lg border border-gray-300 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Confirm new master passcode"
          />
        </div>
      );
    }

    return (
      <div className="relative">
        <input
          type={fieldConfig.type}
          id={fieldKey}
          value={value as string}
          onChange={(e) => handleInputChange(fieldKey, e.target.value)}
          className={`w-full px-4 py-3 rounded-lg border border-gray-300 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent ${fieldConfig.suffix ? 'pr-12' : ''}`}
          placeholder={fieldConfig.description || ''}
          step={fieldConfig.step}
          min={fieldConfig.min}
          max={fieldConfig.max}
          required={fieldConfig.required}
        />
        {fieldConfig.suffix && (
          <div className="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <span className="text-gray-500 text-sm">{fieldConfig.suffix}</span>
          </div>
        )}
      </div>
    );
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
      {/* Flash Messages */}
      {showSuccess && (
        <div className="fixed top-4 right-4 z-50 bg-green-100 border border-green-300 text-green-800 px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 animate-pulse">
          <svg className="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span className="font-medium">Settings updated successfully!</span>
        </div>
      )}

      {showError && (
        <div className="fixed top-4 right-4 z-50 bg-red-100 border border-red-300 text-red-800 px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
          <svg className="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span className="font-medium">{errorMessage}</span>
        </div>
      )}

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Header */}
        <div className="mb-8">
          <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
              <h1 className="text-3xl font-bold text-gray-900">Application Settings</h1>
              <p className="mt-2 text-gray-600">Configure your rental and e-commerce application settings</p>
            </div>
            {isPasscodeVerified && (
              <div className="mt-4 sm:mt-0">
                <button
                  onClick={clearPasscodeVerification}
                  className="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors"
                >
                  <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                  </svg>
                  Clear Verification
                </button>
              </div>
            )}
          </div>
        </div>

        <div className="flex flex-col lg:flex-row gap-8">
          {/* Sidebar Navigation */}
          <div className="lg:w-1/4">
            <nav className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">Settings Sections</h3>
              <ul className="space-y-2">
                {Object.entries(sections).map(([key, title]) => (
                  <li key={key}>
                    <button
                      onClick={() => setActiveSection(key)}
                      className={`w-full flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors text-left ${
                        activeSection === key 
                          ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' 
                          : 'text-gray-700 hover:bg-gray-50'
                      }`}
                    >
                      {renderIcon(settingsConfig[key]?.icon || 'cog', 'w-5 h-5 mr-3')}
                      {title}
                    </button>
                  </li>
                ))}
              </ul>

              {/* Quick Links */}
              <div className="mt-8 pt-6 border-t border-gray-200">
                <h4 className="text-sm font-semibold text-gray-900 mb-3">Quick Links</h4>
                <ul className="space-y-2">
                  <li>
                    <a
                      href="#"
                      className="flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 transition-colors"
                    >
                      <svg className="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                      </svg>
                      Stores Settings
                    </a>
                  </li>
                </ul>
              </div>
            </nav>
          </div>

          {/* Main Content */}
          <div className="lg:w-3/4">
            {requiresPasscodeVerification() ? (
              /* Master Passcode Verification */
              <div className="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
                <div className="text-center">
                  <div className="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-4">
                    <svg className="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                  </div>
                  <h3 className="text-lg font-semibold text-gray-900 mb-2">Master Passcode Required</h3>
                  <p className="text-gray-600 mb-6">This section requires master passcode verification to access sensitive settings.</p>
                  
                  <form onSubmit={handlePasscodeVerification} className="max-w-sm mx-auto">
                    <div className="mb-4">
                      <input
                        type="password"
                        value={passcodeInput}
                        onChange={(e) => setPasscodeInput(e.target.value)}
                        placeholder="Enter master passcode (demo: admin123)"
                        className="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required
                      />
                    </div>
                    
                    <button
                      type="submit"
                      className="w-full px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                    >
                      Verify Passcode
                    </button>
                  </form>
                </div>
              </div>
            ) : (
              /* Settings Form */
              <div className="bg-white rounded-xl shadow-lg border border-gray-100">
                {/* Section Header */}
                <div className="px-8 py-6 border-b border-gray-100">
                  <div className="flex items-center gap-3">
                    <div className="p-2 bg-blue-100 rounded-lg">
                      {renderIcon(settingsConfig[activeSection]?.icon || 'cog', 'w-6 h-6 text-blue-600')}
                    </div>
                    <div>
                      <h2 className="text-2xl font-bold text-gray-900">
                        {settingsConfig[activeSection]?.title || 'Settings'}
                      </h2>
                      <p className="text-gray-600 mt-1">
                        {settingsConfig[activeSection]?.description || 'Configure application settings'}
                      </p>
                    </div>
                  </div>
                </div>

                {/* Form */}
                <form onSubmit={handleSubmit} className="p-8 space-y-8">
                  {activeSection === 'contact' && (
                    /* Special Note for Contact Section */
                    <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                      <div className="flex items-start">
                        <svg className="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                          <p className="text-sm text-blue-800">
                            <strong>Note:</strong> Store locations and addresses that appear on the Contact Us page are managed in the{' '}
                            <a href="#" className="underline hover:text-blue-900">Stores Settings</a> section.
                          </p>
                        </div>
                      </div>
                    </div>
                  )}

                  {Object.entries(settingsConfig[activeSection]?.fields || {}).map(([fieldKey, fieldConfig]) => (
                    <div key={fieldKey} className="space-y-2">
                      <label htmlFor={fieldKey} className="block text-sm font-semibold text-gray-800">
                        {fieldConfig.label}
                        {fieldConfig.required && <span className="text-red-500">*</span>}
                      </label>

                      {renderField(fieldKey, fieldConfig)}

                      {fieldConfig.description && !['textarea'].includes(fieldConfig.type) && (
                        <p className="text-sm text-gray-600">{fieldConfig.description}</p>
                      )}
                    </div>
                  ))}

                  {/* Action Buttons */}
                  <div className="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <button
                      type="submit"
                      className="flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105"
                    >
                      <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                      </svg>
                      Update Settings
                    </button>
                    
                    {activeSection === 'admin' && (
                      <button
                        type="button"
                        className="flex items-center justify-center gap-2 px-6 py-3 bg-yellow-600 text-white rounded-lg font-semibold hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200"
                      >
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Update / Edit
                      </button>
                    )}
                  </div>

                  {activeSection === 'admin' && (
                    <div className="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                      <p className="text-sm text-yellow-800">
                        <strong>Note:</strong> This button requires the Master Passcode to access and edit the encrypted Master Passcode field.
                      </p>
                    </div>
                  )}
                </form>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default SettingsPage;