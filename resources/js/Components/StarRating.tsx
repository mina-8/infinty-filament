import React from 'react'
import { IoStarOutline, IoStarSharp } from 'react-icons/io5';

interface StarRatingProps {
    rating: number;
}
const StarRating = ({ rating }: StarRatingProps) => {
    const Stars = [1, 2, 3, 4, 5];
    return (
        <>
            {Stars.map((_, index) =>
                (index + 1) > rating ? (

                    <IoStarOutline
                        key={index}
                        className='text-yellow-500 ' />
                )
                    :
                    (

                        <IoStarSharp
                            key={index}
                            className='text-yellow-500' />
                    )
            )}
        </>
    )
}

export default StarRating