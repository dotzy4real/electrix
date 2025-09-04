import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import Projects from './Projects.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/portfolio.png';
const bannerPath = '/src/assets/images/resource/pagebanners';

function ProjectsPages() {
    
    const ApiUrl = import.meta.env.VITE_API_URL;
    const [data, setData] = useState([]);
    const [service, setService] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [dataLoaded, setDataLoaded] = useState(false);
          
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
                    { title: data.page_title },
                ]}
                banner={bannerPath+"/"+data.page_banner}
            />
            <Projects />
            <Footer />
            <BackToTop />
        </>
    );
}

export default ProjectsPages;
