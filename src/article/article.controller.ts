import { Controller, Delete, Get, Param, Post, Put } from '@nestjs/common';

@Controller('article')
export class ArticleController {
  @Get()
  findAll(): string {
    return 'Tampil seluruh Article';
  }

  @Get('/:id')
  findOne(@Param() params: any): string {
    return `Tampil detail Article ${params.id}`;
  }

  @Post()
  create(): string {
    return 'Tambah Article';
  }

  @Put('/:id')
  update(@Param() params: any): string {
    return `Update Article ${params.id}`;
  }

  @Delete('/:id')
  delete(@Param() params: any): string {
    return `Delete Article ${params.id}`;
  }
}
