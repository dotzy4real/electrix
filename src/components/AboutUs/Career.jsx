import React from 'react';
import AboutSide from './AboutSide.jsx';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/career.jpeg';

function Career() {
    return (
        <>
            <InnerHeader />
            <PageTitle
                title="Career"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { title: 'Careers' },
                ]}
                banner={PageBanner}
            />
            <section className="blog-details">
                <div className="container">
                <div className="row">
                    <div className="col-xl-8 col-lg-7 general-details-page">
                        <h2>Career</h2>
                        
                        <div className="sec-about-title">
                        <span className="sub-title">Build your career with us</span>
                        </div>
                        <div className='page-content'>
                            <form id="contact_form" name="contact_form" action="/page-contact" method="get">
                                <div className="row">
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="form_name" className="form-control" type="text" placeholder="Enter First Name"/>
                                        </div>
                                    </div>
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="form_subject" className="form-control required" type="text" placeholder="Enter Last Name"/>
                                        </div>
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="form_email" className="form-control required email" type="email" placeholder="Enter Email"/>
                                        </div>
                                    </div>
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="form_phone" className="form-control" type="text" placeholder="Enter Phone"/>
                                        </div>
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="form_email" className="form-control required email" type="email" placeholder="Enter Position"/>
                                        </div>
                                    </div>
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <textarea name="form_phone" className="form-control" type="text" placeholder="Enter Residential Address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div className="mb-3">
                                    <textarea name="form_message" className="form-control required" rows="7" placeholder="Enter Cover Letter (Optional)"></textarea>
                                </div>
                                <div className="mb-5">
                                    <input name="form_botcheck" className="form-control" type="hidden" value="" />
                                    <button type="submit" className="theme-btn btn-style-two mb-3 mb-sm-0 me-3" data-loading-text="Please wait..."><span className="btn-title">Submit Application</span></button>
                                    <button type="reset" className="theme-btn btn-style-two"><span className="btn-title">Reset</span></button>
                                </div>
                            </form>


                        </div>


                    </div>
                    <AboutSide />
                        </div>
                    {/*
                    <div className="col-xl-4 col-lg-5">
                        <div className="sidebar about_side">                            
                            <div className="sidebar__single sidebar__category">
                                <h3 className="sidebar__title">Subsidiaries</h3>
                                <ul className="sidebar__category-list list-unstyled about_in_side">
                                    <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> Armese<span className="icon-right-arrow"></span></Link> </li>
                                    <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> Kilowatt Engineering<span className="icon-right-arrow"></span></Link></li>
                                    <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> Skyview<span className="icon-right-arrow"></span></Link> </li>
                                    <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> MSMSL<span className="icon-right-arrow"></span></Link> </li>
                                </ul>
                            </div>                         
                            <div className="sidebar__single sidebar__category">
                                <h3 className="sidebar__title">Core Values</h3>
                                <ul className="sidebar__category-list list-unstyled  about_in_side">
                                    <li><i className="fa fa-check-circle"></i> Professionalism<span className="icon-right-arrow"></span> </li>
                                    <li><i className="fa fa-check-circle"></i> Innovation<span className="icon-right-arrow"></span></li>
                                    <li><i className="fa fa-check-circle"></i> Reliability<span className="icon-right-arrow"></span> </li>
                                    <li><i className="fa fa-check-circle"></i> Integrity<span className="icon-right-arrow"></span> </li>
                                </ul>
                            </div>                          
                            <div className="sidebar__single sidebar__category">
                                <h3 className="sidebar__title">Mission</h3>
                                <div className="side-bar-content">"To Provide customized electrical engineering solutions to our valued customers through innovation, skilled workforce, technology and exceptional customer experience."
                                </div>
                            </div>                         
                            <div className="sidebar__single sidebar__category">
                                <h3 className="sidebar__title">Vision</h3>
                                <div className="side-bar-content">"To be the leading African provider of Electrical Engineering Solutions"</div>

                            </div>
                        </div>

                    </div>*/}

                </div>
            </section>
            <Footer />
            <BackToTop />
        </>
    );
}

export default Career;
