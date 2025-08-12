import { PageProps } from '@/types';
import { router, usePage } from '@inertiajs/react';
import React from 'react'
import { useTranslation } from 'react-i18next';


interface SocialLink {
    id: number;
    link: string;
    icon_path: string;
}
interface CustomLinkIcon extends PageProps {
    socialicons: SocialLink[];

}
const NewsLetter = () => {
    const { t, i18n } = useTranslation();
    const { socialicons } = usePage<CustomLinkIcon>().props;
    return (
        <section
            className='max-w-7xl mx-auto my-12 shadow-lg p-4 rounded-lg flex justify-around items-center gap-6 flex-col lg:flex-row'
        >
            <div
                className='flex justify-center items-center gap-6'
            >
                {socialicons.length > 0 && socialicons.map((social) => (
                    <a
                        key={social.id}
                        href={social.link}
                        target="_blank"
                        rel="noopener noreferrer"
                        // className="rounded-full bg-primary-color p-2"
                    >
                        <div
                            style={{
                                color: 'black' // لازم يكون اللون هنا مش fill
                            }}
                            className="w-5"
                            dangerouslySetInnerHTML={{
                                __html: social.icon_path.replace(/fill=".*?"/g, 'fill="currentColor"')
                            }}
                        />
                    </a>
                ))}

            </div>
            <div>
                <p
                    className='text-xl font-medium'
                >
                    {t('home.newsletter')}
                </p>
            </div>
            <div
                className='lg:w-2/4'
            >
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        // TODO: send email value to backend or API
                        const email = (e.currentTarget.elements.namedItem('email') as HTMLInputElement).value;
                        router.post(route('contact-form', { lang: i18n.language }), { email: email })
                    }}
                    className="flex flex-col lg:flex-row  "
                >
                    <input
                        type="email"
                        name="email"
                        required
                        placeholder={t('reciveupdate.placeholder')}
                        className={`flex-1 text-2xl px-4 py-2 border border-gray-300 focus:outline-none focus:ring-0 focus:ring-none lg:rounded-s-lg `}
                    />
                    <button
                        type="submit"
                        className={`px-6 py-2 bg-primary-color lg:rounded-e-lg text-white font-medium  transition  `}
                    >
                        {t('reciveupdate.submit') || 'Subscribe'}
                    </button>
                </form>
            </div>
        </section>
    )
}

export default NewsLetter