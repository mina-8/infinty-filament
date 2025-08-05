import { User } from "@/types";
import { usePage } from "@inertiajs/react";
import axios from "axios";

export interface CartItem {
    productId: number;

    title: string;
    image: string;
    price: number;
    optionId: number;
    quantity: number;

}

export interface WichList {
    productId: number;
    title: string;
    image: string;
    optionId: number;
    state:string
    slug:string;

}

let Currentuser : User | null = null

// ====================== CART ======================
export function setUser(user :User){
    return Currentuser = user;
}
export function isUserLoggedIn() : boolean{
    return !!Currentuser;
}
export async function getCart(): Promise<CartItem[]> {
    if (isUserLoggedIn()) {

            return axios.get(route('cart-index')).then((response)=>{

                return response.data.cart
            }).catch((error)=>{
                return []
            });

    } else {
        return JSON.parse(localStorage.getItem('cart') || "[]");
    }
}

function triggerCartUpdateEvent() {
    window.dispatchEvent(new Event("cartUpdated"));
}


export async function mergeCartIfUserLogin() {
    if(isUserLoggedIn()){
        const localCart = JSON.parse(localStorage.getItem('cart') || "[]");
        if(localCart.length > 0){
            await axios.post(route('cart-merge') , {cart : localCart});

            localStorage.removeItem('cart');

            triggerCartUpdateEvent();
        }
    }
}

export  function addtoCart(productId: number, optionId: number, title: string, image: string, price: number, qty: number = 1): Promise<CartItem[]> {
    if(isUserLoggedIn()){
        return axios.post(route('cart-add') , {
            productid: productId ,
            optionid:optionId ,
            quantity:qty}).then(()=>{
                triggerCartUpdateEvent();
                return  getCart()
            });
    }else{

        const cart = JSON.parse(localStorage.getItem("cart") || "[]");
        const ExistingCart = cart.find(
            (item : CartItem) => item.productId === productId && item.optionId === optionId
        );

        if (ExistingCart) {
            ExistingCart.quantity += qty
        } else {
            cart.push({ productId, optionId, title, image, price, quantity: qty })
        }

        localStorage.setItem('cart', JSON.stringify(cart));

        triggerCartUpdateEvent();

        return cart;
    }
}

export function removeFormCart(productId: number, optionId: number, qty: number = 1): Promise<CartItem[]> {
    if(isUserLoggedIn()){
        return axios.post(route('cart-remove') ,
        {productid:productId ,
        optionid:optionId ,
        qunatity:qty}).then(()=>{
            triggerCartUpdateEvent();
            return  getCart();
        });
    }else{

        let cart = JSON.parse(localStorage.getItem("cart") || "[]");

        const ExistingCart = cart.find(
            (item:CartItem) => item.productId === productId && item.optionId === optionId
        );

        if (ExistingCart) {
            if (ExistingCart.quantity > qty) {
                ExistingCart.quantity -= qty
            } else {
                cart = cart.filter(
                    (item:CartItem) => !(item.productId === productId && item.optionId === optionId)
                )
            }
        }
        localStorage.setItem("cart", JSON.stringify(cart));

        triggerCartUpdateEvent();

        return cart;
    }
}

export function removeCompletlyCart(productId: number, optionId: number): Promise<CartItem[]> {
    if(isUserLoggedIn()){
        return axios.post(route('cart-remove-all') ,
         {productid:productId ,
        optionid:optionId}).then(()=>{
            triggerCartUpdateEvent();
            return  getCart();
        });
    }else{
        const cart = JSON.parse(localStorage.getItem("cart") || "[]").filter(
            (item:CartItem) => !(item.productId === productId && item.optionId === optionId)
        );

        localStorage.setItem('cart', JSON.stringify(cart));

        triggerCartUpdateEvent();

        return cart;
    }
}

export function clearlocalcart(){
    localStorage.setItem('cart', '[]')
    triggerCartUpdateEvent();
}

// export function getCartItemQuantity(productId: number, optionId: number): Promise<number> {
//     if(user){

//     }else{

//         const cart = JSON.parse(localStorage.getItem("cart") || "[]");
//         const item = cart.find(p => p.productId === productId && p.optionId === optionId);

//         return item ? item.quantity : 0;
//     }
// }

export async function totalQuantity() : Promise<number> {
    if(isUserLoggedIn()){
        try{
            const response = await axios.get(route('cart-total'));
            return response.data.total || 0
        }catch(error){
            return 0;
        }
    }else{

        const cart = JSON.parse(localStorage.getItem("cart") || "[]");
        const totalItems = cart.reduce((sum: number, item: { quantity: number }) => {
            return sum + (item.quantity || 0)
        }, 0);
        return parseFloat(totalItems.toFixed(2));
    }

}

// export function totalPrice() {
//     const cart = getCart();
//     const totalPrice = cart.reduce((sum: number, item: { price: number, quantity: number }) => {
//         return sum + ((item.price * item.quantity) || 0);
//     }, 0);

//     return parseFloat(totalPrice.toFixed(2));
// }
// ====================== WishList ======================

export function getWichList(): WichList[] {
    return JSON.parse(localStorage.getItem("wishlist") || "[]");
}

export function toggelWishList(productId: number, title: string, image: string, optionId: number , state:string , slug:string): WichList[] {
    let wishlist = getWichList();

    const ExistingWishList = wishlist.find(
        (item) => item.productId === productId && item.optionId === optionId
    );

    if (ExistingWishList) {
        wishlist = wishlist.filter(
            (item) => !(item.productId === productId && item.optionId === optionId)
        );
    } else {
        wishlist.push({ productId, title, image, optionId , state ,slug});
    }

    localStorage.setItem('wishlist', JSON.stringify(wishlist));

    return wishlist;
}