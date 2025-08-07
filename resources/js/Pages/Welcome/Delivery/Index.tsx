import ContentRenderer from '@/Components/ContentRenderer';
import React from 'react'

interface props {
    delivery: {
        content: string;
    };
}
const Index = ({delivery} : props) => {
    
  return (

    <section
    className='mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 min-h-screen mt-48'
    >
        <ContentRenderer content={delivery.content} />
    </section>
  )
}

export default Index