import React from 'react'
import NavLink from '../NavLink'
import Dropdown from '../Dropdown'
import { useTranslation } from 'react-i18next'
import { Link, usePage } from '@inertiajs/react'
import { PageProps } from '@/types'

interface SubCategory {
    id: number;
    title: string;
    proudct_count: number;
    slug: string;
}
interface Category {
    id: number;
    title: string;
    icon: string;
    slug: string;
    subcategory: SubCategory[]
}
interface CustomProp extends PageProps {
    categories: Category[];
}
const CategoryNav = () => {
    const { t, i18n } = useTranslation();
    const { categories } = usePage<CustomProp>().props
    return (
        <>
            {categories.map((item, index) =>

                    <Dropdown
                    key={index}
                        triggerType="hover"
                    >
                        <Link
                            href={route('category', { lang: i18n.language, slug: item.slug })}

                            className='flex items-center'
                        >
                            <img src={item.icon} alt={item.title} className='object-cover h-9' />
                            {item.title}
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
                        </Link>
                        <Dropdown.Content
                            align='center'
                            width='w-48'
                        >
                            {item.subcategory.map((subcat , index)=>
                            <Link
                            key={index}
                            href={route('subcategory' , {lang:i18n.language , category:item.slug, subcategory:subcat.slug})}
                            className='p-4'
                            >
                                {`${subcat.title} ( ${subcat.proudct_count} )`}
                            </Link>
                            )}
                        </Dropdown.Content>
                    </Dropdown>


            )}
        </>
    )
}

export default CategoryNav