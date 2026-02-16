
import { PageProps } from '@/types';
import { Head } from '@inertiajs/react';

import React, { Suspense } from 'react';
import Sliders from './Welcome/Sliders/Sliders';
import Loading from '@/Components/Loading';
import NewsLetter from '@/Components/NewsLetter';
import Exhibition from './Welcome/Exhibition/Exhibition';
import Blog from './Welcome/Blog/blog';
import Category from './Welcome/Category/Category';




export default function Welcome({
    slides = [],
    categories = [],
    blogs = [],
    products = []
}: PageProps<{  slides?: [] , categories?: [] , products?:[] , blogs?: [];}>) {


    return (
        <>
            <Head title="Home" />

            <Sliders slides={slides} />
            <Category categories={categories} />
            <Exhibition products={products}/>
            <Blog blogs={blogs} />
            <NewsLetter />
        </>
    );
}
