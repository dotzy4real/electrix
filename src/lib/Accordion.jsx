import React, { useState } from 'react';

const Accordion = () => {
    const [isActive, setIsActive] = useState({
        status: false,
        key: null,
    });

    const handleToggle = (key) => {
        setIsActive((prevState) => ({
            status: prevState.key !== key,
            key: prevState.key !== key ? key : null,
        }));
    };

    return (
        <ul className="accordion-box">
            {[1, 2, 3].map((key) => (
                <li 
                    key={key} 
                    className={isActive.key === key ? "accordion block active-block" : "accordion block"} 
                    onClick={() => handleToggle(key)}
                >
                    <div className={isActive.key === key ? "acc-btn active" : "acc-btn"}>
                        {key === 1 && "Is this theme support powerful options?"}
                        {key === 2 && "We will continue to build and nurture"}
                        {key === 3 && "Is this theme support powerful options?"}
                        <i className="arrow fal fa-angle-right"/>
                    </div>
                    <div className={isActive.key === key ? "acc-content current" : "acc-content"}>
                        <div className="content">
                            <div className="text">
                                Lorem ipsum dolor sit amet consectetur adipiscing elit condimentum cubilia eget, feugiat felis sociis ad augue senectus ligula.
                            </div>
                        </div>
                    </div>
                </li>
            ))}
        </ul>
    );
};

export default Accordion;
