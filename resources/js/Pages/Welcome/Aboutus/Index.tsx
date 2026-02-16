import ContentRenderer from '@/Components/ContentRenderer'
import React from 'react'
interface props {
    aboutus: {
        content: string;
    };
}
const Index = ({aboutus} :props) => {
  return (
    <section
        className='mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 min-h-screen mt-48'
        >
            <ContentRenderer content={aboutus.content} />
        </section>
  )
}

export default Index