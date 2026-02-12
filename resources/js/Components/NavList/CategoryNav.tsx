import React from 'react'
import NavLink from '../NavLink'
import Dropdown from '../Dropdown'
import { useTranslation } from 'react-i18next'
import { Link, usePage } from '@inertiajs/react'
import { PageProps } from '@/types'


interface Category {
    id: number;
    title: string;
    slug: string;

}
interface CustomProp extends PageProps {
    categories: Category[];
}
const CategoryNav = () => {
    const { t, i18n } = useTranslation();
    const { categories } = usePage<CustomProp>().props
    return (
        <>


                    <Dropdown

                        triggerType="hover"
                    >
                        <div
                            // href={route('category', { lang: i18n.language, slug: item.slug })}

                            className='flex items-center font-bold text-lg text-white'
                        >

                            {t('navbar-links.services')}
                            <svg
                                className="-me-0.5 ms-2 h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fillRule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clipRule="evenodd"
                                />
                            </svg>
                        </div>
                        <Dropdown.Content
                            align='center'
                            width='w-60'
                            contentClasses='flex flex-col bg-white'
                        >
                            {categories.map((subcat , index)=>
                            <Link
                            key={index}
                            href={route('category' , {lang:i18n.language , slug:subcat.slug,})}
                            className='px-4 py-2 hover:bg-primary-color hover:text-white'
                            >
                                {`${subcat.title}`}
                            </Link>
                            )}
                        </Dropdown.Content>
                    </Dropdown>



        </>
    )
}

export default CategoryNav