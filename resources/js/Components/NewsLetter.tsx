import { router } from '@inertiajs/react';
import React from 'react'
import { useTranslation } from 'react-i18next';
import { FaInstagram, FaYoutube } from 'react-icons/fa';
import { FaXTwitter } from 'react-icons/fa6';
import { MdOutlineFacebook } from 'react-icons/md';

const NewsLetter = () => {
    const { t, i18n } = useTranslation()
    return (
        <section
            className='max-w-7xl mx-auto my-12 shadow-lg p-4 rounded-lg flex justify-around items-center gap-6'
        >
            <div
                className='flex justify-center items-center gap-6'
            >
                <MdOutlineFacebook />
                <FaXTwitter />
                <FaInstagram />
                <FaYoutube />
            </div>
            <div>
                <p
                className='text-xl font-medium'
                >
                    {t('home.newsletter')}
                </p>
            </div>
            <div
                className='w-2/4'
            >
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        // TODO: send email value to backend or API
                        const email = (e.currentTarget.elements.namedItem('email') as HTMLInputElement).value;
                        router.post(route('contact-form', { lang: i18n.language }), { email: email })
                    }}
                    className="flex flex-col sm:flex-row  "
                >
                    <input
                        type="email"
                        name="email"
                        required
                        placeholder={t('reciveupdate.placeholder')}
                        className={`flex-1 text-2xl px-4 py-2 border border-gray-300 focus:outline-none focus:ring-0 focus:ring-none rounded-s-lg`}
                    />
                    <button
                        type="submit"
                        className={`px-6 py-2 bg-primary-color rounded-e-lg text-white font-medium  transition  `}
                    >
                        {t('reciveupdate.submit') || 'Subscribe'}
                    </button>
                </form>
            </div>
        </section>
    )
}

export default NewsLetter