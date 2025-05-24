import React, { useEffect, useState } from 'react';

const ProgressBar = ({ title, targetPercentage }) => {
    const [percentage, setPercentage] = useState(0);
    const animationDuration = 3000; // 3 seconds

    useEffect(() => {
        let startTime;
        const animate = (timestamp) => {
            if (!startTime) startTime = timestamp;
            const progress = Math.min((timestamp - startTime) / animationDuration, 1);
            setPercentage(Math.floor(progress * targetPercentage));
            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };

        requestAnimationFrame(animate);
    }, [targetPercentage]);

    return (
        <div className="team-details__progress-single" role="progressbar" aria-valuenow={percentage} aria-valuemin="0" aria-valuemax="100">
            <h4 className="team-details__progress-title">{title}</h4>
            <div className="bar mb-20">
                <div className="bar-inner count-bar" style={{ width: `${percentage}%` }}>
                    <div className="count-text">{percentage}%</div>
                </div>
            </div>
        </div>
    );
};

export default ProgressBar;
