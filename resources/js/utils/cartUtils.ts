export interface CartItem{
    productId: number;

    title:string;
    image:string;
    price:number;
    optionId :number;
    quantity:number;

}

export interface WichList{
    productId: number;
    title:string;
    image:string;
    optionId:number;

}

// ====================== CART ======================

export function getCart() : CartItem[]{
    return JSON.parse(localStorage.getItem('cart') || "[]");
}

function triggerCartUpdateEvent() {
  window.dispatchEvent(new Event("cartUpdated"));
}

export function addtoCart(productId : number , optionId :number , title:string , image:string , price:number , qty:number = 1):CartItem[]{
    const cart = getCart();
    const ExistingCart = cart.find(
        (item)=> item.productId === productId && item.optionId === optionId
    );

    if(ExistingCart){
        ExistingCart.quantity += qty
    }else{
        cart.push({productId , optionId , title , image , price , quantity:qty})
    }

    localStorage.setItem('cart' , JSON.stringify(cart));

    triggerCartUpdateEvent();

    return cart;
}

export function removeFormCart(productId:number , optionId:number , qty:number = 1):CartItem[]{

    let cart = getCart();

    const ExistingCart = cart.find(
        (item)=> item.productId === productId && item.optionId === optionId
    );

    if(ExistingCart){
        if(ExistingCart.quantity > qty){
            ExistingCart.quantity -= qty
        }else{
            cart = cart.filter(
                (item)=> !(item.productId === productId && item.optionId === optionId)
            )
        }
    }
    localStorage.setItem("cart", JSON.stringify(cart));

    triggerCartUpdateEvent();

    return cart;
}

export function removeCompletlyCart (productId : number , optionId :number):CartItem[]{
    const cart = getCart().filter(
        (item) => !(item.productId === productId && item.optionId === optionId)
    );

    localStorage.setItem('cart' , JSON.stringify(cart));

    triggerCartUpdateEvent();

    return cart;
}

export function getCartItemQuantity (productId: number, optionId: number) :number{
    const cart = getCart();
  const item = cart.find(p => p.productId === productId && p.optionId === optionId);

  return item ? item.quantity : 0;
}

export function totalQuantity (){
    const cart = getCart();
    const totalItems=  cart.reduce((sum:number , item:{quantity:number})=>{
        return sum + (item.quantity || 0)
    } , 0);

    return totalItems;
}

export function totalPrice(){
    const cart = getCart();
    const totalPrice = cart.reduce((sum :number , item:{price:number , quantity:number})=>{
        return sum + ((item.price * item.quantity) || 0);
    } , 0);

    return totalPrice;
}
// ====================== WishList ======================

export function getWichList () : WichList[]{
    return JSON.parse(localStorage.getItem("wishlist") || "[]");
}

export function toggelWishList(productId :number , title:string , image:string , optionId:number) : WichList[]{
    let wishlist = getWichList();

    const ExistingWishList = wishlist.find(
        (item)=> item.productId === productId && item.optionId === optionId
    );

    if(ExistingWishList){
        wishlist = wishlist.filter(
            (item) => !(item.productId === productId && item.optionId === optionId)
        );
    }else{
        wishlist.push({productId  , title , image, optionId});
    }

    localStorage.setItem('wishlist' , JSON.stringify(wishlist));

    return wishlist;
}