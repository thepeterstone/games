import sys, pygame

def intro():
	screen.fill(bg_color)
	pygame.time.wait(200)

	main_loop()

def main_loop():
	while 1:
	 	for event in pygame.event.get():
	 		if event.type == pygame.QUIT: outro()
		paint_background()
		paint_pieces()
		pygame.display.update()
		pygame.time.wait(5)

def outro():
	screen.fill(bg_color)
	sys.exit()

def paint_background():
	screen.blit(board, board_pos)

def paint_pieces():
	x = 0;
	for row in stones:
		y = 0;
		for position in row:
			if position == 1:
				screen.blit(black_piece, (x * spacing + x_offset, y * spacing + y_offset))
			elif position == 2:
				screen.blit(white_piece, (x * spacing + x_offset, y * spacing + y_offset))
			y += 1
		x += 1

def init_stones(size=24):
	return  [[0 for col in range(size)] for row in range(size)]

if __name__=='__main__':
	pygame.init()
	screen_size = width, height = 640,480
	bg_color = 174,174,192
	screen = pygame.display.set_mode(screen_size)
	stones = init_stones()
	bg_offset = screen_size[0] - screen_size[1]
	x_offset = 5
	y_offset = 5
	if bg_offset > 0:
		board_size = (screen_size[1], screen_size[1])
		board_pos = (bg_offset, 0)
		x_offset += bg_offset
		orientation = 'horizontal'
	else:
		sys.exit()
	spacing = 25
	board = pygame.image.load("resources/board.png").convert()
	board = pygame.transform.scale(board, board_size)
	black_piece = pygame.image.load("resources/black-stone.gif")
	black_piece = pygame.transform.scale(black_piece, (board_size[0] / 24, board_size[1] / 24))
	white_piece = pygame.image.load("resources/white-stone.gif")
	white_piece = pygame.transform.scale(white_piece, (board_size[0] / 24, board_size[1] / 24))
	intro()