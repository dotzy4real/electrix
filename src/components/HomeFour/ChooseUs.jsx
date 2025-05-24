import React from 'react';
import { Link } from 'react-router-dom';
import ChooseBgImage from '../../assets/images/background/29.jpg';
import ChooseImage1 from '../../assets/images/resource/why-choose-us4-1.jpg';

function ChooseUs({ className }) {
    return (
        <>
            <section className={`why-choose-us-four ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${ChooseBgImage})` }}/>
                <div className="auto-container">
                    <div className="outer-box">
                        <div className="row align-items-center">
                            <div className="content-column col-lg-6">
                                <div className="inner-column">					
                                    <div className="sec-title">
                                        <span className="sub-title">FEATURED PROJECTS</span>
                                        <h2>Why You should <br />Choose us</h2>
                                        <div className="text">Lorem ipsum dolor sit amet consectetur adipiscing elit velit convallis enim vestibulum sagittis sapien ac inceptos eget sociosqu volutpat integer sem curae nisl magnis montes eros et parturient.</div>
                                    </div>
                                    <Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">Explore now</span></Link>
                                </div>
                            </div>
                            <div className="image-column col-lg-6">
                                <div className="inner-column">
                                    <figure className="image m-0 overlay-anim wow fadeInUp animated"><img src={ChooseImage1} alt=""/></figure>
                                    <span className="float-text">FEATURED PROJECTS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default ChooseUs;
