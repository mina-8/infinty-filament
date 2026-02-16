
import { Head, Link } from '@inertiajs/react'
import React from 'react'
import { useTranslation } from 'react-i18next';
interface Results {
    id: number;
    title: string;
    slug: string;
    type: 'product' | 'blog' | 'category';
    route:string;
}
interface Props {
    results: Results[];
    query: string;
}
const Index = ({ results, query }: Props) => {
    const { t, i18n } = useTranslation()
    const typesearch = ['blog', 'product', 'category'];

    const filteredResults = results?.filter(item => typesearch.includes(item.type)) || [];

    return (
        <>
            <Head title="Search" />
            <div className="" >
                {/* Top Banner */}
                {/* <div className="w-full h-32 bg-primary-color bg-cover bg-center" /> */}
                <div
                    className='w-full max-w-7xl mx-auto my-12 flex flex-col justify-center items-center gap-4 h-svh'
                >
                    {/* عنوان البحث */}
                    <h1 className="text-2xl font-bold text-gray-800 mb-4">
                        نتائج البحث عن: <span className="text-yellow-600">"{query}"</span>
                    </h1>

                    {/* قائمة النتائج */}
                    <div className="flex flex-col justify-center items-center gap-4 ">
                        {filteredResults.length > 0 ? (
                            filteredResults.map((item, index) => (
                                <Link
                                    href={route(item.route, { lang: i18n.language, slug: item.slug })}
                                    key={index}
                                    className="bg-white p-4 rounded-xl shadow-md border border-gray-200 "

                                >
                                    {/* <p className="text-sm text-gray-500 capitalize">
                                        النوع: <span className="font-semibold">{item.type}</span>
                                    </p> */}
                                    <h2 className="text-lg font-bold text-gray-800">{item.title}</h2>

                                </Link>
                            ))
                        ) : (
                            <p className="text-gray-600 text-center">لم يتم العثور على نتائج تطابق البحث.</p>
                        )}
                    </div>
                </div>
            </div>


        </>
    );
};

export default Index;
