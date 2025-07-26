import product from '@/../../public/aboutus/product.png'
export const tempproducts = [
        {
            id: 1,
            name: "Product A",
            category: "special",
            image: product,
            rating: 3, // تقييم من 5
            basePrice: 1.620,
            options: [
                { id: 1, label: "كرتون - 18 حبة", price: 1.620 },
                { id: 2, label: "حبة", price: 0.090 },
                { id: 3, label: "شد - 6 حبة", price: 0.540 }
            ]
        },
        {
            id: 2,
            name: "Product B",
            category: "new",
            image: product,
            rating: 4.0,
            basePrice: 2.300,
            options: [
                { id: 1, label: "كرتون - 18 حبة", price: 2.300 },
                { id: 2, label: "حبة", price: 0.150 },
                { id: 3, label: "شد - 6 حبة", price: 0.900 }
            ]
        },
        {
            id: 3,
            name: "Product C",
            category: "top",
            image: product,
            rating: 5.0,
            basePrice: 3.120,
            options: [
                { id: 1, label: "كرتون - 18 حبة", price: 3.120 },
                { id: 2, label: "حبة", price: 0.180 },
                { id: 3, label: "شد - 6 حبة", price: 1.080 }
            ]
        },
        {
            id: 4,
            name: "Product D",
            category: "kids",
            image: product,
            rating: 3.5,
            basePrice: 0.900,
            options: [
                { id: 1, label: "كرتون - 18 حبة", price: 0.900 },
                { id: 2, label: "حبة", price: 0.050 },
                { id: 3, label: "شد - 6 حبة", price: 0.300 }
            ]
        },
        {
            id: 5,
            name: "Product E",
            category: "special",
            image: product,
            rating: 4.2,
            basePrice: 1.800,
            options: [
                { id: 1, label: "كرتون - 18 حبة", price: 1.800 },
                { id: 2, label: "حبة", price: 0.100 },
                { id: 3, label: "شد - 6 حبة", price: 0.600 }
            ]
        }
    ];