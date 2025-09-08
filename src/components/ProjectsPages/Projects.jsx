import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
// Importing the image files
import ProjectImage1 from '../../assets/images/resource/projects/252mw_gas.jpg';
import ProjectImage2 from '../../assets/images/resource/projects/36.5_emergency.jpg';
import ProjectImage3 from '../../assets/images/resource/projects/20mw_gas_plant.jpg';
import ProjectImage4 from '../../assets/images/resource/projects/3mw_diesel_powerplant.jpg';
import ProjectImage5 from '../../assets/images/resource/projects/transmission_substation.jpg';
const imgPath = '/src/assets/images/resource/projects';

function Projects() {
	
	const ApiUrl = import.meta.env.VITE_API_URL;
	const [data, setData] = useState([]);
	const [loading, setLoading] = useState(true);
	const [error, setError] = useState(null);
	const [dataLoaded, setDataLoaded] = useState(false);
	
	useEffect(() => {
		const fetchData = async () => {
		  try {
			const response = await fetch(ApiUrl + "electrix/getProjects");
			if (!response.ok) {
			  throw new Error(`HTTP error! status: ${response.status}`);
			}
			const result = await response.json();
			setData(result);
		  } catch (error) {
			setError(error);
		  } finally {
			setLoading(false);
			setDataLoaded(true);
		  }
		};
	
		fetchData();
	  }, []);


    return (
        <>
			<section className="project-section pb-90 project-dark">
				<div className="large-container">
					<div className="row wow fadeInUp">

					{data.map(item => (

						<div key={item.project_id} className="col-xl-3 col-sm-6 mb-30">
							<div className="project-block">
								<div className="inner-box">
									<div className="image-box">
										<figure className="image"><Link to={"/getProject/details/"+item.project_urltitle+"-"+item.project_id}><img src={imgPath+"/"+item.project_small_pic} alt="Image"/></Link></figure>
									</div>
									<div className="content-box">
										<Link to={"/getProject/details/"+item.project_urltitle+"-"+item.project_id} className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
										<h4 className="title"><Link to={"/getProject/details/"+item.project_urltitle+"-"+item.project_id}>{item.project_title}</Link></h4>
										<span className="cat">{item.project_category_name}</span>
									</div>
									<div className="overlay-1"></div>
								</div>
							</div>
						</div>
					))}

{/*
						<div className="col-xl-3 col-sm-6 mb-30">
							<div className="project-block">
								<div className="inner-box">
									<div className="image-box">
										<figure className="image"><Link to="/what-we-have-done/project-details"><img src={ProjectImage1} alt="Image"/></Link></figure>
									</div>
									<div className="content-box">
										<Link to="/what-we-have-done/project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
										<h4 className="title"><Link to="/what-we-have-done/project-details">EPC of 252 MW Gas Power Plant Construction at Omoku</Link></h4>
										<span className="cat">Plant Construction</span>
									</div>
									<div className="overlay-1"></div>
								</div>
							</div>
						</div>

						<div className="col-xl-3 col-sm-6 mb-30">
							<div className="project-block">
								<div className="inner-box">
									<div className="image-box">
										<figure className="image"><Link to="/what-we-have-done/project-details"><img src={ProjectImage2} alt="Image"/></Link></figure>
									</div>
									<div className="content-box">
										<Link to="/what-we-have-done/project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
										<h4 className="title"><Link to="/what-we-have-done/project-details">EPC of 36.5 MW Emergency Diesel IPP Completed at Sierra-Leone</Link></h4>
										<span className="cat">Plant Construction</span>
									</div>
									<div className="overlay-1"></div>
								</div>
							</div>
						</div>
						<div className="col-xl-3 col-sm-6 mb-30">
							<div className="project-block">
								<div className="inner-box">
									<div className="image-box">
										<figure className="image"><Link to="/what-we-have-done/project-details"><img src={ProjectImage3} alt="Image"/></Link></figure>
									</div>
									<div className="content-box">
										<Link to="/what-we-have-done/project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
										<h4 className="title"><Link to="/what-we-have-done/project-details">EPC of 20MW Gas Power Plant Construction at Escravos</Link></h4>
										<span className="cat">Plant Construction</span>
									</div>
									<div className="overlay-1"></div>
								</div>
							</div>
						</div>
						<div className="col-xl-3 col-sm-6 mb-30">
							<div className="project-block">
								<div className="inner-box">
									<div className="image-box">
										<figure className="image"><Link to="/what-we-have-done/project-details"><img src={ProjectImage4} alt="Image"/></Link></figure>
									</div>
									<div className="content-box">
										<Link to="/what-we-have-done/project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
										<h4 className="title"><Link to="/what-we-have-done/project-details">EPC of 3MW Diesel Power Plant Completed at Obudu, Cross River State</Link></h4>
										<span className="cat">Plant Construction</span>
									</div>
									<div className="overlay-1"></div>
								</div>
							</div>
						</div>
						<div className="col-xl-3 col-sm-6 mb-30">
							<div className="project-block">
								<div className="inner-box">
									<div className="image-box">
										<figure className="image"><Link to="/what-we-have-done/project-details"><img src={ProjectImage4} alt="Image"/></Link></figure>
									</div>
									<div className="content-box">
										<Link to="/what-we-have-done/project-details" className="theme-btn read-more"><i className="fa far fa-arrow-up"></i></Link><br />
										<h4 className="title"><Link to="/what-we-have-done/project-details">EPC of 2x30MVA, 132/33kV Transmission Substation Completed & Commissioned</Link></h4>
										<span className="cat">Transmission Commission</span>
									</div>
									<div className="overlay-1"></div>
								</div>
							</div>
						</div>
						*/}
					</div>
				</div>
			</section>
        </>
    );
}

export default Projects;
