import React from 'react';
import { Link } from 'react-router-dom';
import TeamImg1 from '../../assets/images/resource/team2-1.jpg';
import TeamImg2 from '../../assets/images/resource/team2-2.jpg';
import TeamImg3 from '../../assets/images/resource/team2-3.jpg';
import TeamImg4 from '../../assets/images/resource/team2-4.jpg';

function Team({ className }) {
    return (
        <>
            <section className={`team-section-two ${className || ''}`}>
                <div className="shape-25 bounce-x"/>
                <div className="auto-container">
                    <div className="sec-title">
                        <div className="row">
                            <div className="col-lg-6 col-xl-7">
                                <span className="sub-title">OUR TEAMMATE</span>
                                <h2>Meet Our Latest <br />Teammate</h2>
                            </div>
                            <div className="col-lg-6 col-xl-5">
                                <div className="text">Lorem ipsum dolor sit amet consectetur adipiscing elit velit convallis enim vestibulum sagittis sapien ac inceptos eget sociosqu volutpat integer sem curae nisl magnis montes eros et parturient.</div>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="team-block-two col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to="/page-team-details"><img src={TeamImg1} alt="Image"/></Link></figure>
                                    <div className="social-links">
                                        <Link to="#"><i className="fab fa-twitter"></i></Link>
                                        <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                                        <Link to="#"><i className="fab fa-pinterest-p"></i></Link>
                                        <Link to="#"><i className="fab fa-instagram"></i></Link>
                                    </div>
                                    <span className="share-icon fa fa-share"></span>
                                </div>
                                <div className="info-box">
                                    <h4 className="name"><Link to="/page-team-details">Mark Wooden</Link></h4>
                                    <span className="designation">Founder</span>
                                </div>
                            </div>
                        </div>
                        <div className="team-block-two col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to="/page-team-details"><img src={TeamImg2} alt="Image"/></Link></figure>
                                    <div className="social-links">
                                        <Link to="#"><i className="fab fa-twitter"></i></Link>
                                        <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                                        <Link to="#"><i className="fab fa-pinterest-p"></i></Link>
                                        <Link to="#"><i className="fab fa-instagram"></i></Link>
                                    </div>
                                    <span className="share-icon fa fa-share"></span>
                                </div>
                                <div className="info-box">
                                    <h4 className="name"><Link to="/page-team-details">Jenny Wilson</Link></h4>
                                    <span className="designation">Marketing</span>
                                </div>
                            </div>
                        </div>
                        <div className="team-block-two col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to="/page-team-details"><img src={TeamImg3} alt="Image"/></Link></figure>
                                    <div className="social-links">
                                        <Link to="#"><i className="fab fa-twitter"></i></Link>
                                        <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                                        <Link to="#"><i className="fab fa-pinterest-p"></i></Link>
                                        <Link to="#"><i className="fab fa-instagram"></i></Link>
                                    </div>
                                    <span className="share-icon fa fa-share"></span>
                                </div>
                                <div className="info-box">
                                    <h4 className="name"><Link to="/page-team-details">Jacob Jones</Link></h4>
                                    <span className="designation">Founder</span>
                                </div>
                            </div>
                        </div>
                        <div className="team-block-two col-lg-3 col-md-6 col-sm-12 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to="/page-team-details"><img src={TeamImg4} alt="Image"/></Link></figure>
                                    <div className="social-links">
                                        <Link to="#"><i className="fab fa-twitter"></i></Link>
                                        <Link to="#"><i className="fab fa-facebook-f"></i></Link>
                                        <Link to="#"><i className="fab fa-pinterest-p"></i></Link>
                                        <Link to="#"><i className="fab fa-instagram"></i></Link>
                                    </div>
                                    <span className="share-icon fa fa-share"></span>
                                </div>
                                <div className="info-box">
                                    <h4 className="name"><Link to="/page-team-details">Cody Fisher</Link></h4>
                                    <span className="designation">Web Designer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Team;
