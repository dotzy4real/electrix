import React from 'react';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import About from './About.jsx';
import Video2 from '../HomeTwo/Video2.jsx';
import Service from '../HomeTwo/Service.jsx';
import Project from '../HomeOne/Project.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/about_us.jpeg';

function AboutUs() {

    return (
        <>
            <InnerHeader />
            <PageTitle
                title="Who We Are"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { title: 'Who We Are' },
                ]}
                banner={PageBanner}
            />
            <About />
            {/*<Service />
            <Video2 /> 
            <Project />*/}
            <Footer />
            <BackToTop />
        </>
    );
}

export default AboutUs;
