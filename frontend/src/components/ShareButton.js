import { IoMdShare } from "react-icons/io";
import { useState, useEffect } from 'react';
import { useSpring, animated } from 'react-spring';

export default function ShareButton(){
    const [showNotification, setShowNotification] = useState(false);
    const [isFading, setIsFading] = useState(false);
    const fade = useSpring({opacity: isFading ? 1 : 0});

    const copyLink = () => {
        navigator.clipboard.writeText(window.location.href);
        setShowNotification(true);
        setTimeout(() => setIsFading(true), 100); // Start fading in after a short delay
        setTimeout(() => setIsFading(false), 2000); // Start fading out after 2 seconds
    }

    useEffect(() => {
        if (!isFading) {
            const timer = setTimeout(() => setShowNotification(false), 1000); // Hide notification after 1 second
            return () => clearTimeout(timer);
        }
    }, [isFading]);

    return (
        <div className="flex items-center">
            <button className="text-3xl text-gray-300 ml-4" onClick={copyLink}>
                <IoMdShare />
            </button>
            {showNotification &&
                <animated.div style={fade} className="ml-4 bg-greens-200 text-white p-2 rounded">
                    Link copied to clipboard
                </animated.div>
            }
        </div>
    );
}