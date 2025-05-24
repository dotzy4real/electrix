import React from 'react';
import { Link } from 'react-router-dom';
import ServiceImage1 from '../../assets/images/resource/services/engineering_procurement.jpg';
import ServiceImage2 from '../../assets/images/resource/services/cms_energi.jpg';
import ServiceImage3 from '../../assets/images/resource/services/utility_operations.jpg';
import ServiceImage4 from '../../assets/images/resource/services/kilowatt_engineering.jpg';
import ServiceImage5 from '../../assets/images/resource/services/manufacturing.jpg';

function Services() {
    return (
        <>
            <section className="services-section-home2 pb-70 pt-120">
                <div className="auto-container">
                    <div className="row">
                        <div className="col-lg-4 col-md-6">
                            <div className="service-block-two">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to="/what-we-do/service-details"><img src={ServiceImage1} alt="Image"/></Link></figure>
                                    </div>
                                    <div className="content-box">
                                        <div className="inner"> <i className="icon flaticon-049-wiring"></i>
                                            <h4 className="title"><Link to="/what-we-do/service-details">ENGINEERING, PROCUREMENT & CONSTRUCTION (EPC)</Link></h4>
                                            <div className="text">Income Electrix Limited (IEL) has over 30 years of experience in providing EPC Services in the African Power Sector.</div>
                                        </div>
                                        <Link to="/what-we-do/service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-4 col-md-6">
                            <div className="service-block-two">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to="/what-we-do/service-details"><img src={ServiceImage2} alt="Image"/></Link></figure>
                                    </div>
                                    <div className="content-box">
                                        <div className="inner"> <i className="icon flaticon-024-socket"></i>
                                            <h4 className="title"><Link to="/what-we-do/service-details">CMS ENERJI</Link></h4>
                                            <div className="text">CMS Enerji (“CMS”) are Technical Partners to Income Electrix Limited; and have over 10 years of experience in both green field and brown ﬁeld EPC power plant.</div>
                                        </div>
                                        <Link to="/what-we-do/service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-4 col-md-6">
                            <div className="service-block-two">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to="/what-we-do/service-details"><img src={ServiceImage3} alt="Image"/></Link></figure>
                                    </div>
                                    <div className="content-box">
                                        <div className="inner"> <i className="icon flaticon-001-light-bulb"></i>
                                            <h4 className="title"><Link to="/what-we-do/service-details">UTILITY OPERATIONS AND MANAGEMENT SERVICES</Link></h4>
                                            <div className="text">We are the technical Partner (operator and managers) of the Port Harcourt Distribution Company (PHEDC);</div>
                                        </div>
                                        <Link to="/what-we-do/service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-4 col-md-6">
                            <div className="service-block-two">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to="/what-we-do/service-details"><img src={ServiceImage4} alt="Image"/></Link></figure>
                                    </div>
                                    <div className="content-box">
                                        <div className="inner"> <i className="icon flaticon-024-socket"></i>
                                            <h4 className="title"><Link to="/what-we-do/service-details">KILOWATT ENGINEERING</Link></h4>
                                            <div className="text">ransformer refurbishment, maintenance, repairs and replacement, testing and commissioning of all sizes, up to 132kV.
                                            </div>
                                        </div>
                                        <Link to="/what-we-do/service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-4 col-md-6">
                            <div className="service-block-two">
                                <div className="inner-box">
                                    <div className="image-box">
                                        <figure className="image"><Link to="/what-we-do/service-details"><img src={ServiceImage5} alt="Image"/></Link></figure>
                                    </div>
                                    <div className="content-box">
                                        <div className="inner"> <i className="icon flaticon-001-light-bulb"></i>
                                            <h4 className="title"><Link to="/what-we-do/service-details">MANUFACTURING: METERING SOLUTIONS & MANUFACTURING SERVICES LIMITED (MSMSL)</Link></h4>
                                            <div className="text">Metering Solutions Manufacturing Services Limited (MSMSL) is a 20,580sqm state-of-the-art assembly.</div>
                                        </div>
                                        <Link to="/what-we-do/service-details" className="theme-btn btn-style-one dark-bg"><span className="btn-title">READ MORE <i className="fa fa-arrow-right"></i></span></Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Services;
