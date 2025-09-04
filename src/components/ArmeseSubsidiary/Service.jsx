import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import Service1 from '../../assets/images/armese/theft_detection.jpg';
import Service2 from '../../assets/images/armese/meter_inspection.jpg';
import Service3 from '../../assets/images/armese/installation_of_meters.jpg';
import Service4 from '../../assets/images/armese/auditing_of_installations.jpg';

const imgPath = '/src/assets/images/armese/';


function Service({ className }) {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
	const fetchData = async () => {
	  try {
		const response = await fetch(ApiUrl + "armese/getServices");
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
			<section className={`services-section-three ${className || ''}`}>
				<div className="auto-container">
					<div className="outer-box">
						<div className="row">

						{data.map(item => (
							
							<div key={data.armese_service_id} className="service-block-three col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
								<div className="inner-box">
									<figure className="image mb-0"><Link to="/page-service-details"><img src={imgPath+item.armese_service_pic} alt=""/></Link></figure>
									<div className="icon-box">
										<i className={"icon " + item.armese_service_icon}></i>
									</div>
									<div className="content-box">
										<h4 className="title">{item.armese_service_title}</h4>
										<div className="text">{item.armese_service_snippet}</div>
									</div>
								</div>
							</div>
        				))}


						{/*
							<div className="service-block-three col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
								<div className="inner-box">
									<figure className="image mb-0"><Link to="/page-service-details"><img src={Service1} alt=""/></Link></figure>
									<div className="icon-box">
										<i className="icon flaticon-011-hand-drill"></i>
									</div>
									<div className="content-box">
										<h4 className="title">Theft Detection</h4>
										<div className="text">We capture extra phase, neutral break, polarity reversal, meter bypass, direct hooks and meter tampering</div>
									</div>
								</div>
							</div>
							<div className="service-block-three col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
								<div className="inner-box">
									<figure className="image mb-0"><Link to="/page-service-details"><img src={Service2} alt=""/></Link></figure>
									<div className="icon-box">
										<i className="icon flaticon-020-fuse-box"></i>
									</div>
									<div className="content-box">
										<h4 className="title">Meter Inspection</h4>
										<div className="text">Periodic inspection of meters, analysis of energy consumption, onsite removal of discrepancies  and replacement of faulty meters</div>
									</div>
								</div>
							</div>
							<div className="service-block-three col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
								<div className="inner-box">
									<figure className="image mb-0"><Link to="/page-service-details"><img src={Service3} alt=""/></Link></figure>
									<div className="icon-box">
										<i className="icon flaticon-017-wrench"></i>
									</div>
									<div className="content-box">
										<h4 className="title">Installation of meters</h4>
										<div className="text">Proper installation of new meters and accessories</div>
									</div>
								</div>
							</div>
							<div className="service-block-three col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
								<div className="inner-box">
									<figure className="image mb-0"><Link to="/page-service-details"><img src={Service4} alt=""/></Link></figure>
									<div className="icon-box">
										<i className="icon flaticon-018-tester"></i>
									</div>
									<div className="content-box">
										<h4 className="title">Auditing of Installations</h4>
										<div className="text">Ensuring proper installations
Validating timely meter reading and system billing
Identification of illegal acts. 
</div>
									</div>
								</div>
							</div>*/}
						</div>
					</div>
				</div>
			</section>
        </>
    );
}

export default Service;
