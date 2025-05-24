import React, { useState, useRef, useEffect } from 'react';
import CountUp2 from "react-countup";

export default function CounterUp({ count, time }) {
    const [counterOn, setCounterOn] = useState(false);
    const counterRef = useRef(null);

    useEffect(() => {
        if (typeof window !== 'undefined' && 'IntersectionObserver' in window) {
            const observer = new IntersectionObserver(
                ([entry]) => {
                    if (entry.isIntersecting) {
                        setCounterOn(true);
                        observer.disconnect(); // Stop observing once it has started counting
                    }
                },
                { threshold: 0.5 } // Adjust this threshold as needed
            );

            if (counterRef.current) {
                observer.observe(counterRef.current);
            }

            return () => {
                if (counterRef.current) {
                    observer.unobserve(counterRef.current);
                }
            };
        } else {
            // Fallback for environments without IntersectionObserver
            setCounterOn(true);
        }
    }, []);

    return (
        <div ref={counterRef}>
            {counterOn && (
                <CountUp2 end={count} duration={time} suffix="" />
            )}
        </div>
    );
}
