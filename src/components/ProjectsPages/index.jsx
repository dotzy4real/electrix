import React from 'react';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import Projects from './Projects.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/portfolio.png';

function ProjectsPages() {

    return (
        <>
            <InnerHeader />
            <PageTitle
                title="What We Have Done"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { title: 'What We Have Done' },
                ]}
                banner={PageBanner}
            />
            <Projects />
            <Footer />
            <BackToTop />
        </>
    );
}

export default ProjectsPages;
