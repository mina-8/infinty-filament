import ContentRenderer from "@/Components/ContentRenderer";
import { Head, Link } from "@inertiajs/react";
import { useTranslation } from "react-i18next";

interface Props {
    blog: {
        id: number;
        title: string;
        content: string;
        slug: string;
        image: string;
    };
}
const Index = ({ blog }: Props) => {
    const { t , i18n} = useTranslation();
  return (
    <>
    <Head title={t("blog.title")}/>
        <section
        // className="mt-80  flex flex-col items-center justify-center gap-4 w-full max-w-7xl mx-auto h-screen"
        className="mx-auto w-full max-w-7xl mt-44"
        >
            <h2 className="text-3xl text-center my-4 font-bold text-primary-color">
                {blog.title}
            </h2>
            <div className="flex flex-col justify-center items-center gap-2">
                <img src={blog.image} alt={blog.title} className="w-full max-w-4xl object-cover" />
            </div>
            <div>
                <ContentRenderer content={blog.content}/>
            </div>
        </section>
    </>
  )
}

export default Index