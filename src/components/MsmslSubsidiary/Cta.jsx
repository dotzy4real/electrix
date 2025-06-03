import React from 'react';
import { Link } from 'react-router-dom';
import CtaBgImg from '../../assets/images/background/30.jpg';

function Cta({ className }) {
    return (
        <>
            <section className={`call-to-action-two ${className || ''}`} style={{ backgroundImage: `url(${CtaBgImg})` }}>
                <div className="auto-container">
                    <div className="title-box">
                        <span className="sub-title">WE ARE BUILDING THE ET System</span>
                        <h2 className="title">Trusted Electrical & <br/>Electric Service Provider.</h2>
                        <Link to="/page-about" className="theme-btn btn-style-one hvr-light"><span className="btn-title">Explore now</span></Link>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Cta;
