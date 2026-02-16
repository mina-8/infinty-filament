import i18n from 'i18next';
import { initReactI18next, Translation } from 'react-i18next';


import enTranslation from '../locales/en/translation.json';
import arTranslation from '../locales/ar/translation.json';
i18n.use(initReactI18next)
  .init({
    resources: {
      en: { translation: enTranslation },
      ar: { translation : arTranslation}
    },
    fallbackLng: 'ar', // Default language
    interpolation: {
      escapeValue: false,
    },
  });

export default i18n;
