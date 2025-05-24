import React from 'react';
import BackToTop from '../BackToTop.jsx';
import { Link } from 'react-router-dom';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import Project from '../HomeOne/Project.jsx';
import AboutSide from '../AboutUs/AboutSide.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/portfolio.png';

// Import images
import projectDetailImage from '../../assets/images/resource/projects/project-details/254-mw-gas.jpg';


function ProjectsDetails() {
    return (
        <>
            <InnerHeader />
            <PageTitle
                title="What We Have Done"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { link: '/project-details', title: 'What We Have Done' },
                    { title: 'EPC of 252 MW Gas Power Plant Construction at Omoku' },
                ]}
                banner={PageBanner}
            />
            	
            <section className="project-details">
                <div className="container">
                    <div className="row">
                        <div className="col-xl-8 col-lg-7 general-details-page">
                            <div className="sec-title">
                                <span className="sub-title">WHAT WE HAVE DONE</span>
                                <h2>EPC of 252 MW Gas Power Plant Construction at Omoku</h2>
                            </div>
                            <div className="project-details__top">
                                <div className="project-details__img"><img src={projectDetailImage} alt="Image"/></div>
                            </div>
                            <div className="row justify-content-center">
                                <div className="col-xl-12">
                                    <div className="project-details__content-right">
                                        <div className="project-details__details-box">
                                            <div className="row">
                                                <div className="col-lg-4">
                                                    <p className="project-details__client">Date</p>
                                                    <h4 className="project-details__name">10 January, 2025</h4>
                                                </div>
                                                <div className="col-lg-4">
                                                    <p className="project-details__client">Client</p>
                                                    <h4 className="project-details__name">Omoku Generation Company Limited</h4>
                                                </div>
                                                <div className="col-lg-4">
                                                    <p className="project-details__client">Location</p>
                                                    <h4 className="project-details__name">Omoku, Delta State, Nigeria</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="project-details__content">
                                <div className="row">
                                    <div className="col-xl-12">
                                        <div className="project-details__content-left">
                                            <h3 className="mb-4 mt-5">Details</h3>
                                            <div className="">Design, Engineering, Supply, Installation, Testing and Commissioning of 3 MVA (6x500KVA) Diesel Generating Power Plant at Obudu, Cross River State.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<AboutSide />
                    </div>
                    
                    {/*
                    <div className="row">
                        <div className="col-xl-12">
                            <div className="project-details__pagination-box">
                                <ul className="project-details__pagination list-unstyled clearfix">
                                    <li className="next">
                                        <div className="icon"> <Link to="#" aria-label="Previous"><i className="lnr lnr-icon-arrow-left"></i></Link> </div>
                                        <div className="content">Previous</div>
                                    </li>
                                    <li className="count"><Link to="#"></Link></li>
                                    <li className="count"><Link to="#"></Link></li>
                                    <li className="count"><Link to="#"></Link></li>
                                    <li className="count"><Link to="#"></Link></li>
                                    <li className="previous">
                                        <div className="content">Next</div>
                                        <div className="icon"> <Link to="#" aria-label="Previous"><i className="lnr lnr-icon-arrow-right"></i></Link> </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> */}
                </div>
            </section>
            <Project />
            <Footer />
            <BackToTop />
        </>
    );
}

export default ProjectsDetails;
