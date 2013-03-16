import sys, pygame, hashlib

# 3. A move consists of placing one stone of one's own color on an empty intersection on the board.
# 4. A player may pass his turn at any time.
# 5. A stone or solidly connected group of stones of one color is captured and removed from the board when all the intersections directly adjacent to it are occupied by the enemy. (Capture of the enemy takes precedence over self-capture.)
# 8. A player's territory consists of all the points the player has either occupied or surrounded.
# 9. The player with more territory wins.


class Go(object):
	# events
	(MOVE_PLACE,MOVE_PASS) = (1234123412340,11234123412345)

	def __init__(self, size):
		self.board = Board(size)
		self.screen = View(800,600)

	def run(self):
		self.intro()
		self.main_loop()
		self.outro()

	def intro(self):
		return
		self.screen.paint_intro()
		while 1:
			for event in pygame.event.get():
				if event.type == pygame.KEYDOWN or event.type == pygame.MOUSEBUTTONDOWN: return
				self.menu_event(event)

			pygame.display.update()
			pygame.time.wait(5)

	def main_loop(self):
		while 1:
			for event in pygame.event.get():
				if event.type == pygame.QUIT or (event.type == pygame.KEYDOWN and event.key == pygame.K_ESCAPE): return
				else: self.handle_event(event)

			self.screen.paint_background(self.board.next)
			self.screen.paint_stones(self.board)

			pygame.display.update()
			pygame.time.wait(5)

	def outro(self):
		sys.exit()
		self.screen.paint_outro()
		while 1:
			for event in pygame.event.get():
				if event.type == pygame.QUIT or (event.type == pygame.KEYDOWN and event.key == pygame.K_ESCAPE): sys.exit()
			pygame.time.wait(15)

	def menu_event(self, event):
		pass

	def handle_event(self, event):
		if event.type == pygame.MOUSEBUTTONDOWN:
			on_board = self.screen.coordinates(pygame.mouse.get_pos())
			if on_board:
				x,y = on_board
				self.board.place_piece(x, y)
		elif event.type == self.MOVE_PASS:
			self.board.pass_turn()

class Board:
	(NONE, PASS, MOVE) = (73563456345,3456345625,215273567)
	history = []
	last_move = None

	def __init__(self, size):
		# 1. The board is empty at the onset of the game (unless players agree to place a handicap).
		self.stones = self.init_stones(size)
		# 2. Black makes the first move, after which White and Black alternate.
		self.next = 'black'
		self.history = []


	def init_stones(self, size):
		return  [[0 for col in range(size)] for row in range(size)]

	def place_piece(self, x, y):
		if self.valid_position(x, y, self.next):
			self.stones[x][y] = self.next
			self.next = 'white' if self.next=='black' else 'black'
			self.history.append(str(self.stones))
			self.last_move = self.MOVE

	def valid_position(self, x, y, color):
		if self.stones[x][y] != 0: return False
		# the Rule of liberty - the stone, or its connected stones, must touch an empty space

		# 6. No stone may be played so as to recreate a former board position.
		temp = list(self.stones); temp[x][y] = color
		if str(temp) in self.history: return False
		return True

	def pass_turn(self):
		# 7. Two consecutive passes end the game.
		if self.last_move == self.PASS: self.game_over()
		self.last_move = self.PASS

	def game_over(self):
		crash()


class View(object):
	"""Display a Board"""
	def __init__(self, width, height):
		self.surface = pygame.display.set_mode((width, height))
		self.bg_color = 174,174,192
		bg_offset = width - height
		if bg_offset > 0:
			board_size = (height, height)
			self.offset = (10 + bg_offset, 10)
		else:
			sys.stderr()

		self.spacing = 31

		self.board = pygame.transform.scale(pygame.image.load("resources/board.png").convert(), board_size)
		self.piece = {
			'black': pygame.transform.scale(pygame.image.load("resources/black-stone.gif"), (board_size[0] / 19, board_size[1] / 19)),
			'white': pygame.transform.scale(pygame.image.load("resources/white-stone.gif"), (board_size[0] / 19, board_size[1] / 19))
		}

	def paint_intro(self):
		pass

	def paint_background(self, next):
		x_offset, y_offset = self.offset
		self.surface.fill(self.bg_color)
		self.surface.blit(self.board, (x_offset - 5, y_offset - 5))
		font = pygame.font.Font(None, 22)

		title = font.render("Go", 0, (62,62,62))
		titlepos = title.get_rect()
		titlepos.centerx = x_offset / 2
		self.surface.blit(title, titlepos)

		text = font.render("Next:", 0, (0,0,0))
		self.surface.blit(text, (2,44))
		font = pygame.font.Font(None, 42)
		self.surface.blit(self.piece[next], (40, 40))

	def paint_stones(self, board):
		x_offset, y_offset = self.offset
		x = 0;
		for row in board.stones:
			y = 0;
			for position in row:
				if position in self.piece: self.surface.blit(self.piece[position], (x * self.spacing + x_offset, y * self.spacing + y_offset))
				y += 1
			x += 1

	def paint_outro(self):
		self.surface.fill(self.bg_color)
		font = pygame.font.Font(None, 22)
		title = font.render("Press Esc to quit!", 0, (62,62,62))
		titlepos = title.get_rect()
		titlepos.centerx = self.offset[0] / 2
		self.surface.blit(title, titlepos)

	def coordinates(self, pos):
		x_offset, y_offset = self.offset
		x = (pos[0] - x_offset)
		y = (pos[1] - y_offset)

		tolerance = 20
		if x % self.spacing < tolerance and y % self.spacing < tolerance:
			return (x / self.spacing, y / self.spacing)
		else: return None
				




if __name__=='__main__':
	pygame.init()
	game = Go(19)
	game.run()
