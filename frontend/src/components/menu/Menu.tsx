import { TagSharp } from '@mui/icons-material';
import { Box, Chip } from '@mui/material';
import React from 'react';
import { Link, useParams } from 'react-router-dom';
import { useTagsContext } from '../TagsProvider';
import './menu.scss';

interface MenuProps {
}

const endpointFilter: string = '/blogposts/tag/';

const Menu: React.FC<MenuProps> = ({ }) => {
    const { tag } = useParams()
    const { tags, selected } = useTagsContext();

    return (
        <>
            <div className='menu'>
                <div className="item">
                    <span className="title">Principal</span>
                    <Link className='listItem' to="/">
                        <img src="/home.svg" alt="" />
                        <span className='listItemTitle'>Home</span>
                    </Link>
                    <Link className='listItem' to="/blogposts">
                        <img src="/post2.svg" alt="" />
                        <span className='listItemTitle'>Blog</span>
                    </Link>
                </div>
                <div className="item">
                    <span className="title">Categorias</span>
                    <Box
                        sx={{
                            '& > :not(style)': {
                                m: 1,
                            },
                        }}
                    >
                        {tags.map((aTag) => {
                            return (
                                <Link to={endpointFilter + aTag.name} key={aTag.id}>
                                    <Chip icon={<TagSharp color='primary' />} label={aTag.name} size='small' sx={{ mt: 2, color: "Highlight" }} />
                                </Link>
                            )
                        })}
                    </Box>
                </div>
            </div >
        </>
    );
};

export default Menu;