import { TabContext, TabList, TabPanel } from '@mui/lab';
import { Box, CircularProgress, Stack, Tab } from '@mui/material';
import React from 'react';
import { Link, useNavigate, useParams } from 'react-router-dom';
import HoverChip from '../../components/hoverchip/HoverChip';
import useFetch from '../../hooks/useFetch';
import './blogpost.scss';


interface Blogpost {
    id: string;
    name: string;
    image: string;
    tags: string[];
    created: string;
    content: any[];
    others?: Blogpost[];
}
interface BlogpostContent {
    id: string;
    html?: any;
    image?: string;
    youtube?: string;
    position: number;
    created: string;
}

const endpointDetails: string = 'http://localhost:8001/api/client/web/detail/';
const filterByTagUrl: string = '/blog/';


const BlogpostPage: React.FC<{}> = () => {
    const { id } = useParams()
    const navigate = useNavigate();

    const fetchState = useFetch<{
        blogpost: Blogpost,
        tags: string[],
        others?: Blogpost[]
    }>(endpointDetails + id);
    const [value, setValue] = React.useState("0");
    if (fetchState.state === 'loading' || fetchState.state === 'idle') {
        return (<div><CircularProgress /></div>);
    }

    const handleChange = (_event: React.SyntheticEvent, newValue: string) => {
        setValue(newValue);
    };

    let contentYoutube: any;
    let contentOther: any[] = new Array();
    const blogpost = fetchState.data?.blogpost;
    const others = fetchState.data?.others || [];
    const collection = fetchState.data?.blogpost.content || [];

    collection.map((content: BlogpostContent) => {
        const isYoutube = content.youtube !== null;
        if (isYoutube) {
            contentYoutube = (<div key={content.id} style={{
                "width": "90%"
            }}>
                <div className="video-responsive box">
                    <iframe
                        src={content.youtube}
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowFullScreen
                        title="Embedded youtube"
                    />
                </div>
            </div>)
        }

        const isHtml = content.html !== null;
        {
            isHtml && contentOther.push(<div key={content.id} style={{
                "width": "90%"
            }}><div dangerouslySetInnerHTML={{ __html: content.html }} /></div>)
        }
        const isImage = content.image !== null;
        {
            isImage && contentOther.push(<div key={content.id} style={{
                "width": "90%"
            }}><Link to="">
                    <div className="box">
                        <img src={content.image} alt="" />
                    </div>
                </Link></div>)
        }
    })



    return (
        <div className='blogpost-page'>
            <Box sx={{ width: '100%', typography: 'body1' }}>
                <TabContext value={value}>
                    <TabList onChange={handleChange} aria-label="lab API tabs example">
                        <Tab className='tab-title' label="Contenido" value="0" />
                        <Tab className='tab-title' label="Detalles" value="1" />
                        <Tab className='tab-title' label="Relacionados" value="2" />
                    </TabList>
                    <TabPanel value="0">
                        <Stack
                            direction="row"
                            justifyContent="left"
                            alignItems="center"
                            spacing={2}
                            margin={2}
                        >
                            {blogpost?.tags.map(tag => (
                                <HoverChip label={tag} key={tag} onClick={() => navigate(filterByTagUrl + tag)} />
                            ))}
                        </Stack>
                        {contentYoutube}
                    </TabPanel>
                    <TabPanel value="1">
                        {contentOther.map((element) => {
                            return element
                        })}
                    </TabPanel>
                    <TabPanel value="2">
                        <div className='blog-page'>
                            {others.map((aBlogpost: Blogpost) => {
                                if (aBlogpost.id === blogpost?.id) {
                                    return null;
                                }
                                return (
                                    <Link to={`/blogpost/${aBlogpost.id}`} key={aBlogpost.id} onClick={() => setValue("0")}>
                                        <div className="box blog-item">
                                            <img src={aBlogpost.image} alt="" />
                                            <span>{aBlogpost.name}</span>
                                        </div>
                                    </Link>
                                );
                            })}
                        </div>
                    </TabPanel>
                </TabContext>
            </Box>
        </div >
    );
}






export default BlogpostPage;
