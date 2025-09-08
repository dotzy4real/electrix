import React, { useEffect, useState } from 'react';
import { Link, useParams, useNavigate  } from 'react-router-dom';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import Project from '../HomeOne/Project.jsx';
import AboutSide from '../AboutUs/AboutSide.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/portfolio.png';
const bannerPath = '/src/assets/images/resource/pagebanners';

// Import images
import projectDetailImage from '../../assets/images/resource/projects/project-details/254-mw-gas.jpg';
const imgPath = '/src/assets/images/resource/projects';


function ProjectsDetails() {    
        
                
        const { title } = useParams("title");
        let id = null;
        if (title && typeof title === "string")
        {
            id = title.split("-").pop();
        }
        const ApiUrl = import.meta.env.VITE_API_URL;
        const [data, setData] = useState([]);
        const [project, setProject] = useState([]);
        const [loading, setLoading] = useState(true);
        const [error, setError] = useState(null);
        const [dataLoaded, setDataLoaded] = useState(false);
        
        useEffect(() => {
            const fetchData = async () => {
              try {
                const response = await fetch(ApiUrl + "electrix/getProject/" + id);
                if (!response.ok) {
                  throw new Error(`HTTP error! status: ${response.status}`);
                }
                const result = await response.json();
                setProject(result);
              } catch (error) {
                setError(error);
              } finally {
                setLoading(false);
                setDataLoaded(true);
              }
            };
        
            fetchData();
          }, []);
          
          
          useEffect(() => {
              const fetchData = async () => {
                try {
                  const response = await fetch(ApiUrl + "electrix/getPage/what_we_have_done");
                  if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                  }
                  const result = await response.json();
                  setData(result);
                } catch (error) {
                  setError(error);
                } finally {
                  setLoading(false);
                  setMemberLoaded(true);
                }
              };
          
              fetchData();
            }, []);


    return (
        <>
            <InnerHeader />
            <PageTitle
                title="What We Have Done"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { link: '/what-we-have-done', title: data.page_breadcumb_title },
                    { title: project.project_title },
                ]}
                banner={bannerPath+"/"+data.page_banner}
            />
            	
            <section className="project-details">
                <div className="container">
                    <div className="row">
                        <div className="col-xl-8 col-lg-7 general-details-page">
                            <div className="sec-title">
                                <span className="sub-title">{data.page_title}</span>
                                <h2>{project.project_title}</h2>
                            </div>
                            <div className="project-details__top">
                                <div className="project-details__img"><img src={imgPath+"/"+project.project_pic} alt="Image"/></div>
                            </div>
                            <div className="row justify-content-center">
                                <div className="col-xl-12">
                                    <div className="project-details__content-right">
                                        <div className="project-details__details-box">
                                            <div className="row">
                                                <div className="col-lg-4">
                                                    <p className="project-details__client">Date</p>
                                                    <h4 className="project-details__name">{project.project_date}</h4>
                                                </div>
                                                <div className="col-lg-4">
                                                    <p className="project-details__client">Client</p>
                                                    <h4 className="project-details__name">{project.project_client}</h4>
                                                </div>
                                                <div className="col-lg-4">
                                                    <p className="project-details__client">Location</p>
                                                    <h4 className="project-details__name">{project.project_location}</h4>
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
                                            <div className="">
                                            <div dangerouslySetInnerHTML={{ __html: project.project_content }} />
                                            {/*Design, Engineering, Supply, Installation, Testing and Commissioning of 3 MVA (6x500KVA) Diesel Generating Power Plant at Obudu, Cross River State.*/}
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
