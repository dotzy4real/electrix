import React, { useEffect, useState } from 'react';
import CountUp from 'react-countup';

function CounterUpCom({ endValue = 0, sectionSelect }) {
    const [showCount, setShowCountValue] = useState(false);

    useEffect(() => {
        const rec = document.getElementById(sectionSelect);
        if (rec) {
            const handleScroll = () => {
                const currentScrollPosition =
                    window.pageYOffset || document.documentElement.scrollTop;
                const currentPosition = rec.offsetTop - document.body.scrollTop;
                if (currentScrollPosition + window.innerHeight > currentPosition) {
                    setShowCountValue(true);
                    window.removeEventListener('scroll', handleScroll); // Remove listener once counted
                }
            };

            window.addEventListener('scroll', handleScroll);
            return () => {
                window.removeEventListener('scroll', handleScroll); // Cleanup on component unmount
            };
        }
    }, [sectionSelect]);

    return <>{showCount ? <CountUp delay={0} duration={3} end={endValue} /> : 0}</>;
}

export default CounterUpCom;
