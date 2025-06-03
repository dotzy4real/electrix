import React from 'react';
import {Link} from 'react-router-dom';
import ProjectThumb1 from '../../assets/images/msmsl/facility/facility1.jpg';
import ProjectThumb2 from '../../assets/images/msmsl/facility/facility2.jpg';
import ProjectThumb3 from '../../assets/images/msmsl/facility/facility3.jpg';
import ProjectThumb4 from '../../assets/images/msmsl/facility/facility4.jpg';
import ProjectThumb5 from '../../assets/images/msmsl/facility/facility3.jpg';
import ProjectThumb6 from '../../assets/images/msmsl/facility/facility2.jpg';

function Footer({ className }) {
    return (
        <>
            <footer className={`main-footer ${className || ''}`}>
                <div className="widgets-section">
                    <div className="auto-container">
                        <div className="row">
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget about-widget">
                                    <h5 className="about-title">About us</h5>
                                    <div className="text">Metering Solutions Manufacturing Services Limited (MSMSL) is an indigenous manufacturing and services company commissioned in September, 2017. Based in Onna, Akwa Ibom State, Nigeria.</div>
                                    <ul className="social-icon-two">
                                        <li><Link to="#"><i className="fab fa-twitter"></i></Link></li>
                                        <li><Link to="#"><i className="fab fa-instagram"></i></Link></li>
                                        <li><Link to="#"><i className="fab fa-facebook"></i></Link></li>
                                        <li><Link to="#"><i className="fab fa-linkedin-in"></i></Link></li>
                                    </ul>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget">
                                    <h5 className="widget-title">Explore</h5>
                                    <ul className="user-links">
                                        <li><Link to="#">About Company</Link></li>
                                        <li><Link to="#">Meet the Team</Link></li>
                                        <li><Link to="#">News & Media</Link></li>
                                        <li><Link to="#">Our Projects</Link></li>
                                        <li><Link to="#">Contact</Link></li>
                                    </ul>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget contact-widget">
                                    <h5 className="widget-title">Contact</h5>
                                    <div className="widget-content">
                                        <div className="text">Nkop Road, Awa-Iman
Akwa Ibom

</div>
                                        <ul className="contact-info">
                                            {/*<li><i className="fa fa-envelope"></i> <Link to="mailto:needhelp@yourdomain.com">needhelp@company.com</Link><br /></li>*/}
                                            <li><i className="fa fa-phone-square"></i><Link to="tel:+2349057777754">(+234) 9057777754

                                            </Link><br /></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget gallery-widget">
                                    <h5 className="widget-title">Gallery</h5>
                                    <div className="widget-content">
                                        <div className="outer clearfix">
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb1} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb2} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb3} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb4} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb5} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb6} alt=""/>
                                                </Link>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="footer-bottom">
                    <div className="auto-container">
                        <div className="inner-container">
                            <div className="copyright-text">&copy; 2025 <Link to="/">MSMSL</Link> | All Rights Reserved
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </>
    );
}

export default Footer;
