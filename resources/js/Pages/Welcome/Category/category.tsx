import { Link } from "@inertiajs/react";
import React from "react";
import { useTranslation } from "react-i18next";
interface props {
    categories: {
        id: number;
        title: string;
        slug: string;
        image: string;
    }[];
}
const Category = ({ categories }: props) => {
    const { t, i18n } = useTranslation();
    return (
        <section className="w-full max-w-6xl mx-auto relative my-8">
            <h2 className="text-center my-4 font-bold text-3xl text-primary-color">
                {t("home.categories")}
            </h2>
            {/* categories */}
            <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mx-12">
                {categories.map((category) => (
                    <div
                        key={category.id}
                        className="relative aspect-square bg-cover bg-center rounded-xl "
                        style={{ backgroundImage: `url(${category.image})` }}
                    >

                        <div className="absolute bottom-0 left-0 bg-white px-4 w-2/3 rounded-tr-xl rounded-bl-xl">
                            <div className="flex flex-col items-end">
                                <p className="text-center mt-2 font-semibold">
                                    {category.title}
                                </p>
                                <Link
                                    href={`/category/${category.slug}`}
                                    className="bg-third-color px-2 py-1 rounded-md text-white my-2"
                                >
                                    {t("home.shop_now")}
                                </Link>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </section>
    );
};

export default Category;
