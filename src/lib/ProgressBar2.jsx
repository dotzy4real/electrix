import React, { useEffect, useState } from 'react';

const ProgressBar2 = ({ title, targetPercentage }) => {
    const [percentage, setPercentage] = useState(0);
    const animationDuration = 3000;

    useEffect(() => {
        const increment = targetPercentage / (animationDuration / 10);
        let currentPercentage = 0;

        const interval = setInterval(() => {
            currentPercentage += increment;
            if (currentPercentage >= targetPercentage) {
                currentPercentage = targetPercentage;
                clearInterval(interval);
            }
            setPercentage(Math.floor(currentPercentage));
        }, 10);

        return () => clearInterval(interval);
    }, [targetPercentage, animationDuration]);

    return (
            <div className="skill-bar">
                <div className="bar-inner">
                    <div className="bar progress-line" style={{ width: `${percentage}%` }}>
                    <div className="skill-percentage">
                        <div className="count-box">
                        <span className="count-text">{percentage}%</span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
    );
};

export default ProgressBar2;
